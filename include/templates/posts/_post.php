<div class="post">
	<?php
		echo '<h2><a href="' . PathToRoot::get() . 'posts/view/' . $post->id . '">' . $post->title . '</a></h2>';

		if ($GLOBALS['config']['multi_author'])
			echo '<h3>by <a href="' . PathToRoot::get() . 'authors/view/' . $post->author->id . '">' . $post->author->name . '</a></h3>';

		echo '<h3>' . date($GLOBALS['config']['date_format'], strtotime($post->timestamp)) . '</h3>';

		echo '<div class="body' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? ' snippet' : '') . '">' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? $post->snippet : $post->body) . '</div>';

		if ($post->has_snippet || $GLOBALS['config']['show_comments']) {
			echo '<div class="links">';
			if ($post->has_snippet)
				echo '<a href="' . PathToRoot::get() . 'posts/view/' . $post->id . '#continue" class="snippet-link">continue reading</a>';
			if ($GLOBALS['config']['show_comments'])
				echo '<a href="' . PathToRoot::get() . 'posts/view/' . $post->id . '#comments" class="comment-link">' . count($post->comments) . ' comment' . ( count($post->comments) == 1 ? '' : 's') .'</a>';
			echo '</div>';
		}
	?>
</div>
