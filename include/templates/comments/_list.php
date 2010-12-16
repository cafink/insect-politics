<div id="comment-list">

	<h2>Recent Comments</h2>

	<ul>
		<?php foreach ($comments as $comment) { ?>
			<li class="comment">

				<div class="header">
					<span class="commenter">
						<?php
							$name = htmlentities($comment->name);
							if (false) //(!empty($comment->homepage))
								$name = '<a href="' . htmlentities($comment->homepage) . '">' . $name . '</a>';
							echo $name;
						?>
					</span>

					on

					<a href="<?php echo PathToRoot::get(); ?>posts/view/<?php echo $comment->post->id; ?>#comment-<?php echo $comment->id; ?>">
						<?php echo $comment->post->title; ?>:
					</a>
				</div>

				<div class="content"><?php
					echo is_null($GLOBALS['config']['comment_html']) ? htmlentities($comment->snippet) : strip_tags($comment->snippet, $GLOBALS['config']['comment_html']);
					if (strlen($comment->body) > strlen($comment->snippet))
						echo '&hellip;';
				?></div>

			</li>
		<?php } ?>
	</ul>

</div>
