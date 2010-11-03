<h1><?php echo $author->name; ?></h1>

<img
	src="<?php echo PathToRoot::get(); ?>images/authors/<?php echo $author->images['large']; ?>"
	width="<?php echo $GLOBALS['config']['img']['large']['width']; ?>"
	height="<?php echo $GLOBALS['config']['img']['large']['height']; ?>"
	alt="<?php echo $author->name; ?>"
	class="author-large"
/>

<p><?php echo $author->bio; ?></p>
