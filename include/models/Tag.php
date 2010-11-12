<?php

include_once 'models/Post.php';

class Tag extends BaseRow {

	public $table_name = "tags";

	protected $scopes = array(
		'alphabetical' => array('sort_fields' => 'name')
	);

	function setup () {
		$this->associations = array(
			'posts' => new ManyToMany(array(
				'class'      => 'Post',
				'table'      => 'posts_tags_map',  
				'local_key'  => 'tag_id',
				'remote_key' => 'post_id'
			))
		);
	}

	// @todo: Find a better way of determining popular tags.
	// Can we do it in our query, instead of querying for all rows
	// and doing the work in PHP?
	function popular ($num = null) {

		if (is_null($num))
			$num = $GLOBALS['config']['sidebar_tag_limit'];

		$tags = $this->find();

		$more = count($tags) > $num;

		usort($tags, '_popsort');

		$tags = array_slice($tags, 0, $num);

		return array($tags, $more);
	}

	function validate ($type) {
		$errors = array();
		return $errors;
	}

}

function TagTable () {
	return new Tag();
}

//  Sort tags according to "popularity."
//  The more posts are tagged with a given tag,
//  the more popular we consider it.
function _popsort ($a, $b) {
	if (count($a->posts) == count($b->posts))
		return 0;
	return (count($a->posts) > count($b->posts)) ? -1 : 1;
}

?>
