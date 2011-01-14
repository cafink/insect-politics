<?php

include_once 'models/Author.php';
include_once 'models/Comment.php';
include_once 'models/Tag.php';

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

	function validate ($type) {
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

	function callbackAfterFetch () {

		// Used for putting tags into the Keywords meta tag
		$this->tag_list = array();
		foreach ($this->tags as $tag)
			$this->tag_list[] = $tag->name;

		// Link images to the correct directory.
		$this->body = preg_replace(
			'|(<img\s.*?src=")(.*?\s/>)|is',
			'$1' . PathToRoot::get() . 'images/posts/' . $this->short_name . '/$2',
			$this->body
		);

		$this->comments = $this->scope('approved')->comments;

		$snippet_marker = $GLOBALS['config']['snippet_marker'];

		// Normally, we'd check strpos() by using the !== operator to compare
		// it to the Boolean FALSE, because strpos() can return a non-Boolean
		// value which evaluates to FALSE (specifically, the Integer 0).  But
		// in our case, there's no snippet to extract if the marker is the
		// first thing in the post, so doing it this way is okay.
		$this->has_snippet = strpos($this->body, $snippet_marker) ? true : false;

		if ($this->has_snippet) {
			$this->snippet = substr($this->body, 0, strpos($this->body, $snippet_marker));

			$this->body = str_replace($snippet_marker, '<a name="continue"></a>', $this->body);

		} else {
			$this->snippet = $this->body;
		}

		// Because we can't use relative links in feeds.
		$this->feed_body = preg_replace(
			'|(<img\s.*?src=")(.*?\s/>)|is',
			'$1' . 'http://' . $_SERVER['SERVER_NAME'] . '$2',
			$this->body
		);

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
}

function PostTable () {
	return new Post();
}

?>
