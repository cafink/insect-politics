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

	// Find the most popular tags, sorted in descending order of popularity.
	function popular ($num = null) {

		if (is_null($num))
			$num = $GLOBALS['config']['sidebar_tag_limit'];

		$tags = $this->query('
			SELECT DISTINCT t.*, (SELECT COUNT(*) FROM posts_tags_map WHERE tag_id = t.id) AS count
			FROM tags t, posts_tags_map m
			WHERE t.id = m.tag_id
			ORDER BY count DESC, name
		');

		$more = count($tags) > $num;

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
