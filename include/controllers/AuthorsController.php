<?php

include_once 'models/Author.php';

class AuthorsController extends ApplicationController {

	function view ($coords) {

		$this->author = AuthorTable()->get($coords['id']);

		// We already have $this->author->posts, but we can't as easily paginate that.
		list($this->posts, $this->pager_html) = $this->paginate('Post', 'author_id = ?', array($coords['id']));

		$this->page['sidebar'] = $this->sidebar(array('author' => $this->author));
		$this->page['title'] = $this->author->name;
		$this->render();
	}

	// Feed of one author's posts
	function feed ($coords) {

		$this->author = AuthorTable()->get($coords['id']);
		$this->posts = $this->author->posts;

		$this->page['layout'] = false;
		$this->render(array('file' => "feeds/{$GLOBALS['config']['feed']}.php"));

	}
}

?>
