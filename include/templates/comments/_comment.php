<div class="comment<?php if ($comment->by_author) echo ' by-author'; ?>" id="comment-<?php echo $comment->id; ?>">
	<div class="header">
		<span class="name">
			<?php
				if ($comment->by_author)
					$name = '<a href="' . PathToRoot::get() . 'authors/view/' . $comment->author->id . '">' . $comment->author->name . '</a>';
				elseif (!empty($comment->homepage))
					$name = '<a href="' . htmlentities($comment->homepage) . '">' . htmlentities($comment->name) . '</a>';

				echo $name;
			?>
		</span>

		<?php

			$email = null;
			if ($comment->by_author)
				$email = $comment->author->email;
			elseif ($GLOBALS['config']['comment_display_email'] && !empty($comment->email))
				$email = $comment->email;

			if (!empty($email))
				echo '(<a href="mailto:' . htmlentities($email) . '">' . htmlentities($email) . '</a>)';

		?>

		says&hellip;
	</div>
	<div class="timestamp"><?php echo date($GLOBALS['config']['date_format'], strtotime($comment->timestamp)); ?></div>
	<div class="body"><?php echo str_replace("\n", '<br />', htmlentities($comment->body)); ?></div>
</div>
