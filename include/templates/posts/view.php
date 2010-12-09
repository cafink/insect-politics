<div id="prev-next">
	<?php

		if (!is_null($post->prev))
			echo '<a id="prev" href="' . PathToRoot::get() . 'posts/view/' . $post->prev->id . '">' . $post->prev->title . '</a>';
		if (!is_null($post->next))
			echo '<a id="next" href="' . PathToRoot::get() . 'posts/view/' . $post->next->id . '">' . $post->next->title . '</a>';

	?>
</div>

<h1><?php echo $post->title; ?></h1>

<h3>
	by
	<?php
		$name = $post->author->name;
		if ($link)
			$name = '<a href="' . PathToRoot::get() . 'authors/view/' . $post->author->id . '">' . $name . '</a>';
		echo $name;
	?>
</h3>

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
