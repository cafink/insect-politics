<div id="comments">

	<h3>Comments</h3>

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
				include 'include/templates/comments/_comment.php';
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
