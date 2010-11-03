<div id="comment-list">
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

				<div class="content">
					<?php
						echo htmlentities($comment->snippet);
						if (strlen($comment->body) > strlen($comment->snippet))
							echo '&hellip;';
					?>
				</div>

			</li>
		<?php } ?>
	</ul>
</div>
