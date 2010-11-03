<h1><?php echo $post->title; ?></h1>

<!--<h2>by <a href="<?php echo PathToRoot::get(); ?>authors/view/<?php echo $post->author->id; ?>"><?php echo $post->author->name; ?></a></h2>-->

<?php

	echo '<h3>' . date($GLOBALS['config']['date_format'], strtotime($post->timestamp)) . '</h3>';

	echo $post->body;

	if (!empty($post->tags)) {

		echo '<div id="post-tags">';

		$count = 0;
		$first = true;
		$last = false;
		foreach ($post->tags as $tag) {
			$count++;

			if ($count == count($post->tags))
				$last = true;

			$class = 'tag';
			if ($first)
				$class .= ' first';
			if ($last)
				$class .= ' last';

			// Zero-width space (&#8203;) used to separate words,
			// so that the text-transform: capitalize; style may be applied.
			echo '<a href="' . PathToRoot::get() . 'tags/view/' . $tag->id . '" class="' . $class . '">' . $tag->name . '</a>&#8203;';
			$first = false;
		}

		echo '</div>';
	}

	if ($GLOBALS['config']['show_comments']) {
		$comments = $post->comments;
		include 'include/templates/comments/_comments.php';
	}

?>
