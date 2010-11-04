<?php

include_once 'models/Author.php';
include_once 'models/Comment.php';
include_once 'models/Tag.php';

class Post extends BaseRow {

	public $table_name = 'posts';
	public $default_order_by = 'timestamp ASC';

	function setup() {
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

	// @todo:  Accept either a tag name or id
	function tagScope ($tag_id) {
		return $this->scope(array('where' => "id IN (SELECT {$this->associations['tags']->local_key} FROM {$this->associations['tags']->table} WHERE {$this->associations['tags']->remote_key} = ?)", 'params' => array($tag_id)));
	}

	function validate ($type) {
		$errors = array();
		return $errors;
	}

	function callbackAfterFetch () {

		// Need to think of a better way to handle images in posts.
		$this->body = str_replace(
			'<img src="',
			'<img src="' . PathToRoot::get() . "images/posts/" . $this->short_name . '/', // Why the double quotes?
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

		// Mark the comments made by the post's author.
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
