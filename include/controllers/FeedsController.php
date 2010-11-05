<?php

include_once 'models/Post.php';

class FeedsController extends ApplicationController {

	function index ($coords) {

		$this->posts = PostTable()->find(array('sort_fields' => 'timestamp', 'sort_directions' => 'DESC'));

		if (!$GLOBALS['config']['multi_author'])
			$this->author = AuthorTable()->find(array('first' => true));

		$this->page['layout'] = false;
		$this->render(array('action' => $coords['type']));
	}
}

?>
