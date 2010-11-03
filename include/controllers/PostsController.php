<?php

include_once 'models/Post.php';

class PostsController extends ApplicationController {

	function index ($coords) {

		list($this->posts, $this->pager_html) = $this->paginate('Post');

		$this->page['sidebar'] = $this->sidebar();
		$this->render();
	}

	function view ($coords) {

		if (is_numeric($coords['id']))
			$this->post = PostTable()->get($coords['id']);
		else
			$this->post = PostTable()->find(array('fields' => 'short_name', 'values' => $coords['id'], 'first' => true));

		$this->comment_pending = isset($_GET['comment-pending']);

		$comment_form_view = new TemplateView('comments/_form.php');
		$comment_form_view->assign('post', $this->post);
		$this->comment_form = $comment_form_view->getOutput();

		$this->page['sidebar'] = $this->sidebar(array('multi_author' => false));
		$this->page['title'] = $this->post->title;
		$this->render();
	}

}

?>
