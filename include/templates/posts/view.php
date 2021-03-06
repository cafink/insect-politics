<div id="prev-next">
	<?php

		if (!is_null($post->prev))
			echo '<a id="prev" href="' . PathToRoot::get() . 'posts/' . $post->prev->short_name . '">' . $post->prev->title . '</a>';
		if (!is_null($post->next))
			echo '<a id="next" href="' . PathToRoot::get() . 'posts/' . $post->next->short_name . '">' . $post->next->title . '</a>';

	?>
</div>

<div id="post" class="post">

	<h1><?php echo $post->title; ?></h1>

	<div class="byline">
		by
		<?php
			$name = $post->author->name;
			if ($link)
				$name = '<a href="' . PathToRoot::get() . 'authors/view/' . $post->author->id . '">' . $name . '</a>';
			echo $name;
		?>
	</div>

	<?php

		echo '<div class="timestamp">' . date($GLOBALS['config']['date_format'], strtotime($post->timestamp)) . '</div>';

		echo '<div class="body">' . $post->body_html . '</div>';

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

				// Zero-width space (&#8203;) used to separate words (instead of no space),
				// so that the text-transform: capitalize; style may be applied.
				echo '<a href="' . PathToRoot::get() . 'tags/' . $tag->link_name . '" class="' . $class . '">' . $tag->name . '</a>&#8203;';
				$first = false;
			}

			echo '</div>';
		}
	?>

</div>

<?php
	if ($GLOBALS['config']['show_comments'])
		echo $comments;
?>
