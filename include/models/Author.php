<?php

include_once 'models/Post.php';

class Author extends BaseRow {

	public $table_name = "authors";

	function setup() {
		$this->associations = array(
			'posts' => new HasMany(array(
				'class' => 'Post',
				'key'   => 'author_id'
			))
		);
	}

	function validate ($type) {
		$errors = array();
		return $errors;
	}

	function callbackAfterFetch () {

		$this->short_bio = $this->bio;

		$this->images = array();
		foreach ($GLOBALS['config']['img'] as $size => $details)
			$this->images[$size] = $details['prefix'] . $this->img . $details['suffix'] . '.jpg';
	}
}

function AuthorTable () {
	return new Author();
}

?>
