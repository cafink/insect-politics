<?php

include_once 'models/Tag.php';

class TagsController extends ApplicationController {

	function index ($coords) {

		$this->tags = TagTable()->scope('alphabetical')->find();

		$this->page['sidebar'] = $this->sidebar();
		$this->page['title'] = 'List of tags';
		$this->render();
	}

	function view ($coords) {

		$this->tag = TagTable()->get($coords['id']);

		list($this->tag->posts, $this->pager_html) = $this->paginate(PostTable()->tagScope($coords['id']));

		$this->page['sidebar'] = $this->sidebar(array('tag' => $this->tag));
		$this->page['title'] = $this->tag->name;
		$this->render();
	}

	// Feed of one tag's posts
	function feed ($coords) {

		$this->tag = TagTable()->get($coords['id']);
		$this->posts = $this->tag->posts;

		if (!AuthorTable()->multiple())
			$this->author = AuthorTable()->find(array('first' => true));

		$this->page['layout'] = false;
		$this->render(array('file' => "feeds/{$coords['type']}.php"));

	}
}

?>
