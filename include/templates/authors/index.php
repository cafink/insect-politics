<div id="authors">

	<h1>Authors</h1>

	<?php foreach ($authors as $author) { ?>

		<h2><?php echo $author->name; ?></h2>

		<img
			src="<?php echo PathToRoot::get(); ?>images/authors/<?php echo $author->images['large']; ?>"
			width="<?php echo $GLOBALS['config']['img']['large']['width']; ?>"
			height="<?php echo $GLOBALS['config']['img']['large']['height']; ?>"
			alt="<?php echo $author->name; ?>"
			class="author-large"
		/>

		<p><?php echo $author->bio; ?></p>

	<?php } ?>
</div>