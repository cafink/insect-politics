<div class="comment<?php if ($comment->by_author) echo ' by-author'; ?>" id="comment-<?php echo $comment->id; ?>">
	<div class="header">
		<span class="name">
			<?php
				if ($comment->by_author) {
					if ($link)
						$name = '<a href="' . PathToRoot::get() . 'authors/view/' . $comment->author->id . '">' . $comment->author->name . '</a>';
					else
						$name = $comment->author->name;
				} elseif (!empty($comment->homepage)) {
					$name = '<a href="' . htmlentities($comment->homepage) . '">' . htmlentities($comment->name) . '</a>';
				} else {
					$name = $comment->name;
				}

				echo $name;
			?>
		</span>

		<?php

			$email = null;
			if ($GLOBALS['config']['comment_display_email']) {
				if ($comment->by_author)
					$email = $comment->author->email;
				elseif (!empty($comment->email))
					$email = $comment->email;
			}

			if (!empty($email))
				echo '(<a href="mailto:' . htmlentities($email) . '">' . htmlentities($email) . '</a>)';

		?>

		says&hellip;
	</div>
	<div class="timestamp"><?php echo date($GLOBALS['config']['date_format'], strtotime($comment->timestamp)); ?></div>
	<!-- User input has already been escaped in the model. -->
	<div class="body"><?php echo $comment->body_html; ?></div>

	<?php
		$auth = new \pmill\Auth\Authenticate;
		if ($auth->isLoggedIn() && is_null($comment->author_id)) {
	?>
		<div class="report-spam">
			<a href="<?php echo PathToRoot::get(); ?>comments/spam/<?php echo $comment->id; ?>">
				[ mark as spam ]
			</a>
		</div>
	<?php } ?>
</div>
