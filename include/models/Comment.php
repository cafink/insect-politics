<?php

//include_once 'models/Author.php';
include_once 'models/Post.php';

class Comment extends BaseRow {

	public $table_name = 'comments';

	protected $scopes = array(
			'approved' => array('fields' => 'status', 'values' => 'approved')
	);

	function setup() {
		$this->associations = array(
			'post' => new BelongsTo(array(
				'class' => 'Post',
				'key'   => 'post_id'
			)),

			'author' => new BelongsTo(array(
				'class' => 'Author',
				'key'   => 'author_id'
			))
		);

		// Moved to setup() because we couldn't use the config variable otherwise.
		// Is this the reason associations are defined in setup()?
		$this->default_order_by = "timestamp {$GLOBALS['config']['comment_order']}";
	}

	function validate ($type) {
		$errors = array();

		if (empty($this->body))
			$errors['body'] = 'Please enter your <strong>comment</strong>.';
		if (empty($this->post_id))
			$errors['post_id'] = 'No <strong>post ID</strong> was specified.';

		return $errors;
	}

	function callbackBeforeSave () {

		// @todo: Check whether an author is logged in, and if so,
		// set the author_id foreign key, and set name, e-mail & homepage to NULL.
		$this->author_id = null;

		$this->ip = $_SERVER['REMOTE_ADDR'];

		$this->timestamp = date($GLOBALS['config']['timestamp_format']);

		$this->status = $GLOBALS['config']['approve_comments'] ? 'pending' : 'approved';
	}

	function callbackAfterFetch() {

		if (empty($this->name))
			$this->name = 'Anonymous';

		if (!empty($this->homepage) && (!(substr($this->homepage, 0, 7) == 'http://' || substr($this->homepage, 0, 8) == 'https://')))
			$this->homepage = 'http://' . $this->homepage;

		if (strlen($this->body) > $GLOBALS['config']['comment_snippet_length'])
			$this->snippet = substr($this->body, 0, $GLOBALS['config']['comment_snippet_length']);
		else
			$this->snippet = $this->body;

	}
}

function CommentTable () {
	return new Comment();
}

?>
