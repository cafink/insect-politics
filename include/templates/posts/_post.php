<div class="post">

	<?php
		echo '<h2><a href="' . PathToRoot::get() . 'posts/' . $post->short_name . '">' . $post->title . '</a></h2>';

		if (AuthorTable()->multiple())
			echo '<div class="byline">by <a href="' . PathToRoot::get() . 'authors/view/' . $post->author->id . '">' . $post->author->name . '</a></div>';

		echo '<div class="timestamp">' . date($GLOBALS['config']['date_format'], strtotime($post->timestamp)) . '</div>';

		echo '<div class="body' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? ' snippet' : '') . '">' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? $post->snippet : $post->body) . '</div>';

		if ($post->has_snippet || $GLOBALS['config']['show_comments']) {
			echo '<div class="links">';
			if ($post->has_snippet)
				echo '<a href="' . PathToRoot::get() . 'posts/' . $post->short_name . '#continue" class="snippet-link">continue reading</a>';
			if ($GLOBALS['config']['show_comments'])
				echo '<a href="' . PathToRoot::get() . 'posts/' . $post->short_name . '#comments" class="comment-link">' . count($post->comments) . ' comment' . ( count($post->comments) == 1 ? '' : 's') .'</a>';
			echo '</div>';
		}
	?>

</div>
