<div class="comment<?php if ($comment->by_author) echo ' by-author'; ?>" id="comment-<?php echo $comment->id; ?>">
	<div class="header">
		<span class="name">
			<?php
				$name = htmlentities($comment->name);

				if ($comment->by_author)
					$name = '<a href="' . PathToRoot::get() . 'authors/view/' . $comment->author->id . '">' . $name . '</a>';
				elseif (!empty($comment->homepage))
					$name = '<a href="' . htmlentities($comment->homepage) . '">' . $name . '</a>';

				echo $name;
			?>
		</span>

		<?php
			if ($comment->by_author)
				echo '(<a href="mailto:' . htmlentities($comment->author->email) . '">' . htmlentities($comment->author->email) . '</a>)';
			elseif ($GLOBALS['config']['comment_display_email'] && !empty($comment->email))
				echo '(<a href="mailto:' . htmlentities($comment->email) . '">' . htmlentities($comment->email) . '</a>)';
		?>

		says&hellip;
	</div>
	<div class="timestamp"><?php echo date($GLOBALS['config']['date_format'], strtotime($comment->timestamp)); ?></div>
	<div class="body"><?php echo str_replace("\n", '<br />', htmlentities($comment->body)); ?></div>
</div>
