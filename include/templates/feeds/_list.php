<div id="feed-list">

	<?php if (isset($author) || isset($tag)) { ?>
		<ul>
			<li>
				<?php
					if (isset($author)) {
						$type = 'author';
						$id   = $author->id;
						echo "{$author->name}'s posts";
					} elseif (isset($tag)) {
						$type = 'tag';
						$id   = $tag->id;
						echo "posts tagged &ldquo;{$tag->name}&rdquo;";
					}
				?>
				<ul>
					<?php
						foreach ($GLOBALS['config']['feeds'] as $feed => $name)
							echo '<li><a href="' . PathToRoot::get() . $type . 's/feed/' . $id . '/' . $feed . '">' . $name . '</a></li>';
					?>
				</ul>
			</li>
			<li>
				all posts
	<?php } ?>

	<ul>
		<?php
			foreach ($GLOBALS['config']['feeds'] as $feed => $name)
				echo '<li><a href="' . PathToRoot::get() . 'posts/feed/' . $feed . '">' . $name . '</a></li>';
		?>
	</ul>

	<?php
		if (isset($author) || isset($tag))
			echo '</li></ul>';
	?>

</div>
