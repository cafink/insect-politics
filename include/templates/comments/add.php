<h1>Add Comment</h1>

<h2><?php echo $post->title; ?></h2>

<?php echo '<div class="body' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? ' snippet' : '') . '">' . (($GLOBALS['config']['use_snippets'] && $post->has_snippet) ? $post->snippet : $post->body) . '</div>'; ?>

<!-- We don't know ahead of time whether the user will preview his comment,
     so we can't know whether the form should link to the #preview or #comment-form element.
     Wrapping them in a single div addresses both cases. -->
<div id="comment-area">
	<?php
		if (isset($preview) && !empty($preview))
			echo $preview;
		echo $comment_form;
	?>
</div>
