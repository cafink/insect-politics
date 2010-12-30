<?php

include_once 'models/Post.php';

class ArchiveController extends ApplicationController {

	function index ($coords) {

		$this->years = PostTable()->yearMonthList();

		$this->page['sidebar'] = $this->sidebar();
		$this->render();
	}

	function view ($coords) {

		list($all_posts, $this->pager_html) = $this->paginate(PostTable()->monthScope($coords['year'], $coords['month']));

		$this->posts = array();
		foreach($all_posts as $post) {
			$post_view = new TemplateView('posts/_post.php');
			$post_view->assign('post', $post);
			$this->posts[] = $post_view->getOutput();
		}

		// Is there a more efficient way to do this?
		$this->year  = $coords['year'];
		$this->month = $coords['month'];

		$this->page['sidebar'] = $this->sidebar();
		$this->render();
	}

}

?>
