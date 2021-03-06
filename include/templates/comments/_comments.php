<div id="comments">

	<h2>Comments</h2>

	<?php if($comment_pending) { ?>
		<div class="message">
			Thank you for submitting your comment.
			It will be posted shortly, pending administrative approval.
		</div>
	<?php } ?>

	<?php
		if (empty($comments)) {
			echo '<p>No comments have yet been posted.</p>';
		} else {
			foreach ($comments as $comment)
				echo $comment;
		}
	?>
</div>

<?php
	if (
		$GLOBALS['config']['enable_comments'] && (
			!$GLOBALS['config']['comments_expire'] ||
			time() < (strtotime($post->timestamp) + $GLOBALS['config']['comment_expiration'])
		)
	)
		echo $comment_form;
?>
