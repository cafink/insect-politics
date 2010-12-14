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
	<div class="body">
		<?php
			// If no HTML is allowed in comments, all entities will be escaped,
			// so the actual HTML code will be displayed.
			// If some tags are allowed, all disallowed tags will be stripped instead of escaped.
			$body = is_null($GLOBALS['config']['comment_html']) ? htmlentities($comment->body) : strip_tags($comment->body, $GLOBALS['config']['comment_html']);
			echo str_replace("\n", '<br />', $body);
		?>
	</div>
</div>
