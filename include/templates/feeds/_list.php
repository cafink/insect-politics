<?php

	if (isset($author))
		$authors = array($author);
	elseif (isset($authors) && !is_array($authors))
		$authors = array($authors);

	if (isset($tag))
		$tags = array($tag);
	if (isset($tags) && !is_array($tags))
		$tags = array($tags);

?>

<div id="feed-list">

	<h2>Feeds</h2>

	<?php if (isset($authors)) { ?>
		<ul id="author-feeds">
			<?php foreach ($authors as $author) { ?>
				<li>
					<a href="<?php echo PathToRoot::get(); ?>authors/feed/<?php echo $author->id; ?>">
						<?php echo $author->name; ?>'s posts
					</a>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

	<?php if (isset($tags)) { ?>
		<ul id="tag-feeds">
			<?php foreach ($tags as $tag) { ?>
				<li>
					<a href="<?php echo PathToRoot::get(); ?>tags/feed/<?php echo $tag->id; ?>">
						posts tagged &ldquo;<?php echo $tag->name; ?>&rdquo;
					</a>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

	<ul id="all-feeds"><li><a href="<?php echo PathToRoot::get(); ?>posts/feed">all posts</a></li></ul>

</div>
