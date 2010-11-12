<?php

include_once 'models/Author.php';

class AuthorsController extends ApplicationController {

	function index ($coords) {

		// If there is only one author, redirect to his page.
		if (!AuthorTable()->multiple()) {
			$author = AuthorTable()->find(array('first' => true));
			$this->redirect('authors/view/' . $author->id);
		}

		$this->authors = AuthorTable()->find();

		$this->page['sidebar'] = $this->sidebar(array('show_authors' => false));
		$this->render();
	}

	function view ($coords) {

		$this->author = AuthorTable()->get($coords['id']);

		// We already have $this->author->posts, but we can't as easily paginate that.
		list($this->posts, $this->pager_html) = $this->paginate('Post', 'author_id = ?', array($coords['id']));

		$this->page['sidebar'] = $this->sidebar(array('author' => $this->author));
		$this->page['title'] = $this->author->name;
		$this->render();
	}
}

?>
