<?php

include_once 'models/Author.php';
include_once 'models/Comment.php';
include_once 'models/Tag.php';
include_once 'models/View.php';
include_once 'vendor/parsedown/Parsedown.php';
include_once 'vendor/smartypants/smartypants.php';

class PostParser extends Parsedown {

	private $short_name;

	// Instantiate with post short_name, for use in image path, below.
	// It seems like we should be able to use the existing $instance_name for
	// this purpose, but it doesn't actually seem to be accessible from within
	// the inlineImage() function.
	static function instance ($short_name, $instance_name = 'default') {
		$instance = parent::instance($instance_name);
		$instance->short_name = $short_name;
		return $instance;
	}

	// Prepend image filename with full path.
	protected function inlineImage ($Excerpt) {
		$Image = parent::inlineImage($Excerpt);
		if (isset($Image['element']['attributes']['src']))
			$Image['element']['attributes']['src'] = PathToRoot::get() . 'images/posts/' . $this->short_name . '/' . $Image['element']['attributes']['src'];
		return $Image;
	}
}

// A different parser is needed for the feed, since relative links won't work.
// Maybe we should just use absolute URLs for both to make things simpler?
class FeedParser extends PostParser {
	protected function inlineImage ($Excerpt) {
		$Image = parent::inlineImage($Excerpt);
		if (isset($Image['element']['attributes']['src']))
			$Image['element']['attributes']['src'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $Image['element']['attributes']['src'];
		return $Image;
	}
}

class Post extends BaseRow {

	public $table_name = 'posts';
	public $default_order_by = 'timestamp DESC';

	function setup () {
		$this->associations = array(
			'author' => new BelongsTo(array(
				'class' => 'Author',
				'key'   => 'author_id'
			)),

			'comments' => new HasMany(array(
				'class' => 'Comment',
				'key'   => 'post_id',
			)),

			'tags' => new ManyToMany(array(
				'class'      => 'Tag',
				'table'      => 'posts_tags_map',
				'local_key'  => 'post_id',
				'remote_key' => 'tag_id'
			))
		);
	}

	function tagScope ($tag_id) {
		return $this->scope(array('where' => "id IN (SELECT {$this->associations['tags']->local_key} FROM {$this->associations['tags']->table} WHERE {$this->associations['tags']->remote_key} = ?)", 'params' => array($tag_id)));
	}

	function monthScope ($year, $month) {

		// Accept parameters in either order.
		if (strlen($year) == 2 && strlen($month) == 4)
			// One-line variable swap.  Thanks, Optimus Pete (tech.petegraham.co.uk)!
			list($year, $month) = array($month, $year);

		$year  = sprintf("%04d", $year);
		$month = sprintf("%02d", $month);

		return $this->scope(array('where' => "timestamp LIKE '{$year}-{$month}%'"));
	}

	function validate ($type = 'INSERT') {
		$errors = array();
		return $errors;
	}

	// Return a list of all the months for which posts exist.
	// Format: array(year => array(month => post_count))
	function yearMonthList () {

		$posts = $this->find();

		$years = array();

		foreach ($posts as $post) {

			$time_parts = explode('-', $post->timestamp);

			if (!isset($years[$time_parts[0]]))
				$years[$time_parts[0]] = array();

			if (!isset($years[$time_parts[0]][$time_parts[1]]))
				$years[$time_parts[0]][$time_parts[1]] = 1;
			else
				$years[$time_parts[0]][$time_parts[1]] += 1;
		}

		// Start with the most recent and go backwards.
		// We could probably just sort the posts by date when we call find() above,
		// but we subsequently manipulate the array, and will have gaps in the indeces
		// because of array_unique().  That shouldn't matter in practice, but let's
		// keep things organized, anyway.
		krsort($years);
		foreach ($years as $year)
			krsort($year);

		return $years;
	}

	// Used in the copyright notice.
	function firstPostYear() {
		$date = $this->find(array(
			'sort_fields'     => 'timestamp',
			'sort_directions' => 'ASC',
			'first'           => true,
			'callback'        => false
		))->timestamp;

		return date('Y', strtotime($date));
	}

	function callbackAfterFetch () {

		// Used for putting tags into the Keywords meta tag
		$this->tag_list = array();
		foreach ($this->tags as $tag)
			$this->tag_list[] = $tag->name;

		$this->comments = $this->scope('nonspam')->scope('approved')->comments;

		// We have to perform the SmartyPants transformation before the Markdown
		// one because our Markdown parser, automatically converts double quotes
		// to the &quot; entity, which prevents them from being transformed.
		$this->body_html = PostParser::instance($this->short_name, 'post')->text(SmartyPants($this->body, $GLOBALS['config']['smartypants_format']));
		$this->feed_body = FeedParser::instance($this->short_name, 'feed')->text(SmartyPants($this->body, $GLOBALS['config']['smartypants_format']));

		$snippet_marker = $GLOBALS['config']['snippet_marker'];

		// Normally, we'd check strpos() by using the !== operator to compare
		// it to the Boolean FALSE, because strpos() can return a non-Boolean
		// value which evaluates to FALSE (specifically, the Integer 0).  But
		// in our case, there's no snippet to extract if the marker is the
		// first thing in the post, so doing it this way is okay.
		$this->has_snippet = strpos($this->body_html, $snippet_marker) ? true : false;

		if ($this->has_snippet) {
			$this->snippet = substr($this->body_html, 0, strpos($this->body_html, $snippet_marker));

			$this->body_html = str_replace($snippet_marker, '<a name="continue"></a>', $this->body_html);

		} else {
			$this->snippet = $this->body_html;
		}

		// Mark the comments made by the post's author.
		// Should we also mark comments made by other authors?
		foreach ($this->comments as $comment) {
			if (!empty($comment->author_id) && $comment->author_id == $this->author->id)
				$comment->by_author = true;
			else
				$comment->by_author = false;
		}

		// Determine the previous/next posts.
		$this->prev = $this->find(array(
			'where'           => "timestamp < '{$this->timestamp}'",
			'sort_fields'     => 'timestamp',
			'sort_directions' => 'DESC',
			'first'           => true,
			'callback'        => false
		));
		$this->next = $this->find(array(
			'where'           => "timestamp > '{$this->timestamp}'",
			'sort_fields'     => 'timestamp',
			'sort_directions' => 'ASC',
			'first'           => true,
			'callback'        => false
		));
	}

	function registerView () {

		$ip_address = $_SERVER['REMOTE_ADDR'];

		$view = ViewTable()->find(array(
			'fields' => array('post_id', 'ip'),
			'values' => array($this->id, $ip_address),
			'first' => true
		));

		if (empty($view)) {

			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$view = new View(array(
				'post_id'    => $this->id,
				'ip'         => $ip_address,
				'user_agent' => $user_agent,
				'count'      => 1
			));
			$view->save();

		} else {

			// If this IP has already viewed this post, increment the count, but
			// don't worry about the timestamp of individual views, or further
			// tracking their user agent.
			$view->increment();

		}
	}
}

function PostTable () {
	return new Post();
}

?>
