<h1>Add Comment</h1>

<h2><?php echo $post->title; ?></h2>

<?php
	echo '<div class="body' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? ' snippet' : '') . '">' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? $post->snippet : $post->body) . '</div>';
	echo $comment_form;
?>
