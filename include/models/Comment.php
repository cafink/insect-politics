<?php

//include_once 'models/Author.php';
include_once 'models/Post.php';

class Comment extends BaseRow {

	public $table_name = 'comments';

	protected $scopes = array(
		'nonspam' => array('fields' => 'spam', 'values' => false),
		'approved' => array('fields' => 'status', 'values' => 'approved')
	);

	function setup () {
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

	function validate ($type = 'INSERT') {
		$errors = array();

		if (empty($this->body))
			$errors['body'] = 'Please enter your <strong>comment</strong>.';
		if (empty($this->post_id))
			$errors['post_id'] = 'No <strong>post ID</strong> was specified.';

		return $errors;
	}

	// We normally escape user-input in the view, but because we're doing something
	// a little more complicated here (since some tags might be allowed), and because
	// it needs to display in multiple places (specifically, both the regular comment
	// display and the pre-submission preview), it seems prudent to abstract it out
	// to the model.
	function filter ($body) {

		// If no HTML is allowed in comments, all entities will be escaped,
		// so the actual HTML code will be displayed.
		// If some tags are allowed, all disallowed tags will be stripped instead of escaped.
		$body = is_null($GLOBALS['config']['comment_html']) ? htmlentities($body) : strip_tags($body, $GLOBALS['config']['comment_html']);
		return str_replace("\n", '<br />', $body);
	}

	function callbackBeforeSave () {

		// @todo: Check whether an author is logged in, and if so,
		// set the author_id foreign key, and set name, e-mail & homepage to NULL.
		// Update the detectSpam() function below, too!
		$this->author_id = null;

		$this->ip = $_SERVER['REMOTE_ADDR'];

		$this->timestamp = date($GLOBALS['config']['timestamp_format']);

		// Note that, in theory, we don't actually want to perform these actions
		// upon every save.  But in practice, comments can't be edited and so
		// are only saved once, upon their initial submission.  Should this ever
		// change, this logic will probably need to move to the controller.
		$this->detectSpam();
		$this->status = $GLOBALS['config']['approve_comments'] ? 'pending' : 'approved';
	}

	function callbackAfterFetch () {

		if (empty($this->name))
			$this->name = 'Anonymous';

		if (!empty($this->homepage) && (!(substr($this->homepage, 0, 7) == 'http://' || substr($this->homepage, 0, 8) == 'https://')))
			$this->homepage = 'http://' . $this->homepage;

		$this->body = $this->filter($this->body);

		if (strlen($this->body) > $GLOBALS['config']['comment_snippet_length'])
			$this->snippet = substr($this->body, 0, $GLOBALS['config']['comment_snippet_length']);
		else
			$this->snippet = $this->body;
	}

	function detectSpam () {

		$comment_data = array(
			'blog' => PathToRoot::get(),
			'user_ip' => $this->ip,
			'user_agent' => null, // This field is required, but we don't track it right now
			'referrer' => null, // this isn't required, but we should start tracking it, too
			'permalink' => PathToRoot::get() . 'posts/view/' . $this->id,
			'comment_type' => 'comment',
			'comment_author' => $this->name,
			'comment_author_email' => $this->email,
			'comment_author_url' => $this->homepage,
			'comment_content' => $this->body,
			'comment_date_gmt' => $this->created, // seems to work, but I'm not certain this is the right format, and it isn't in GMT
			'comment_post_modified_gmt' => $this->post->updated,
			'blog_lang' => 'en',
			'blog_charset' => 'UTF-8', // again, I'm not actually sure whether this is right
			'user_role' => 'user',
			'is_test' => false
		);

		// Test data to ensure that a comment is/isn't marked as spam:
		// $comment_data['comment_author'] = 'viagra-test-123';
		// $comment_data['user_role'] = 'administrator';

		$url = $GLOBALS['config']['akismet_key'] . '.rest.akismet.com';
		$path = '/1.1/comment-check';

		$curl = curl_init($url . $path);

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => http_build_query($comment_data)
		));

		$results = curl_exec($curl);
		// $info = curl_getinfo($curl);
		// $error = curl_error($curl);

		curl_close($curl);

		if ($results === false) {
			// There was an error.  Allow it through.
			// @todo: log this (message in $error, above).
			$this->spam = false;
		} else {
			$this->spam = $results == 'true';
		}
	}
}

function CommentTable () {
	return new Comment();
}

?>
