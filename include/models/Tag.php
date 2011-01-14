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

	function getByName ($name) {

		// Tag names might come from the URL, where spaces are replaced by hyphens,
		// but they might also contain a legitimate hyphen.
		$tag_like = str_replace('-', '%', $name);

		$tag =  $this->find(array(
			'where' => "LOWER(name) LIKE LOWER('{$tag_like}')",
			'first' => true
		));

		if (is_null($tag))
			throw new BaseRowRecordNotFoundException('Could not locate Tag ' . $name);

		return $tag;
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

		$obj_tags = array();
		foreach ($tags as $i => $tag) {
			$obj_tags[$i] = new Tag($tag);
			$obj_tags[$i]->callbackAfterFetch();
		}

		return array($obj_tags, $more);
	}

	function validate ($type) {
		$errors = array();
		return $errors;
	}

	function callbackAfterFetch() {

		// A URL-friendly version of the tag name.
		// Specifically, we replace spaces with hyphens,
		// but we might need to adjust this in the future,
		// should we ever use other URL-unfriendly characters
		// in tag names.
		$this->link_name = strtolower(str_replace(' ', '-', $this->name));
	}

}

function TagTable () {
	return new Tag();
}
