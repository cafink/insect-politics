<?php

include_once 'models/Post.php';

class FeedsController extends ApplicationController {

	function index ($coords) {

		$this->posts = PostTable()->find(array('sort_fields' => 'timestamp', 'sort_directions' => 'DESC'));

		$this->page['layout'] = false;
		$this->render(array('action' => $coords['type']));
	}
}

?>
