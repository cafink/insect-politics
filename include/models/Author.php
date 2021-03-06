<?php

include_once 'models/Post.php';
require_once 'vendor/php-auth/src/pmill/Auth/Interfaces/AuthUser.php';

class Author extends BaseRow implements \pmill\Auth\Interfaces\AuthUser {

	public $table_name = "authors";
	public $default_order_by = 'created ASC'; // Organize by seniority

	function setup () {
		$this->associations = array(
			'posts' => new HasMany(array(
				'class' => 'Post',
				'key'   => 'author_id'
			))
		);
	}

	function validate ($type = 'INSERT') {
		$errors = array();
		return $errors;
	}

	// Returns a boolean indicating whether or not there are multiple authors.
	// Right now, that just requires a simple rowCount(), but it might be
	// trickier later (by the addition of an "active" field, for example),
	// hence this dedicated function.
	function multiple () {
		return $this->rowCount() > 1;
	}

	function callbackAfterFetch () {
		$this->social_media = !empty($this->facebook_username) || !empty($this->twitter_username);
	}

	function gravatarUrl ($params) {

		// default size
		if (empty($params['s']))
			$params['s'] = 192;

		// default "mystery man" image
		if (empty($params['d']))
			$params['d'] = 'mm';

		// @todo: Intelligently decide between http/https
		$url = 'https://www.gravatar.com/avatar/';
		$hash = md5(strtolower(trim($this->email)));

		return $url . $hash . '?' . http_build_query($params);
	}

	public function getAuthId() {
		return $this->id;
	}

	public function getAuthUsername() {
		return $this->email;
	}

	public function getAuthPassword() {
		return $this->password;
	}

	public function getTwoFactorSecret() {
		return null;
	}
}

function AuthorTable () {
	return new Author();
}

?>
