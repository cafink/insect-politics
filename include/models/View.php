<?php

include_once 'models/Post.php';

class View extends BaseRow {

	public $table_name = 'views';

	function setup () {
		$this->associations = array(
			'post' => new BelongsTo(array(
				'class' => 'Post',
				'key'   => 'Post_id'
			))
		);
	}

	function increment () {
		$this->count++;
		$this->save();
	}
}

function ViewTable () {
	return new View();
}

?>
