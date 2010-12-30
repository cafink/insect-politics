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

		list($tag_posts, $this->pager_html) = $this->paginate(PostTable()->tagScope($coords['id']));

		$this->tag->posts = array();
		foreach($tag_posts as $post) {
			$post_view = new TemplateView('posts/_post.php');
			$post_view->assign('post', $post);
			$this->tag->posts[] = $post_view->getOutput();
		}

		$this->page['sidebar'] = $this->sidebar(array('tag' => $this->tag));
		// Tag names are capitalized using text-transform: capitalize; elsewhere,
		// but that won't work for the page title.
		$this->page['title'] = ucwords($this->tag->name);
		$this->page['keywords'] = $this->tag->name;
		$this->render();
	}

	// Feed of one tag's posts
	function feed ($coords) {

		$this->tag = TagTable()->get($coords['id']);
		$this->posts = $this->tag->posts;

		if (!AuthorTable()->multiple())
			$this->author = AuthorTable()->find(array('first' => true));

		$this->page['layout'] = false;
		$this->render(array('file' => "feeds/{$GLOBALS['config']['feed']}.php"));

	}
}

?>
