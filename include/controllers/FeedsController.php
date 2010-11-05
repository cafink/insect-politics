<?php

include_once 'models/Post.php';

class FeedsController extends ApplicationController {

	function index ($coords) {

		// Is this the right sort order for the posts?
		// If not, don't forget to adjust the "last updated" fields in the feeds!
		$this->posts = PostTable()->find(array('sort_fields' => 'timestamp', 'sort_directions' => 'DESC'));

		if (!$GLOBALS['config']['multi_author'])
			$this->author = AuthorTable()->find(array('first' => true));

		$this->page['layout'] = false;
		$this->render(array('action' => $coords['type']));
	}
}

?>
