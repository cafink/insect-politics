<?php

include_once 'models/Author.php';

class AuthorsController extends ApplicationController {

	function index ($coords) {

		// If there is only one author, redirect to his page.
		if (!$GLOBALS['config']['multi_author']) {
			$author = AuthorTable()->find(array('first' => true));
			$this->redirect('authors/view/' . $author->id);
		}

		$this->authors = AuthorTable()->find();

		$this->page['sidebar'] = $this->sidebar(array('show_authors' => false));
		$this->render();
	}

	function view ($coords) {

		$this->author = AuthorTable()->get($coords['id']);

		$this->page['sidebar'] = $this->sidebar(array('show_authors' => false));
		$this->page['title'] = $this->author->name;
		$this->render();
	}
}

?>
