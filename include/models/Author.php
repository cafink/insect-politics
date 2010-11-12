<?php

include_once 'models/Post.php';

class Author extends BaseRow {

	public $table_name = "authors";
	public $default_order_by = 'created DESC'; // Organize by seniority

	function setup () {
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

	// Returns a boolean indicating whether or not there are multiple authors.
	// Right now, that just requires a simple rowCount(), but it might be
	// trickier later (by the addition of an "active" field, for example),
	// hence this dedicated function.
	function multiple() {
		return $this->rowCount() > 1;
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
