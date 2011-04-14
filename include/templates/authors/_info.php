<?php

	$name = $author->name;
	$img  = '<img ' .
		'src="' . PathToRoot::get() . 'images/authors/' . $author->img . '" ' .
		'width="' . $GLOBALS['config']['author_img']['width'] . '" ' .
		'height="' . $GLOBALS['config']['author_img']['height'] . '" ' .
		'alt="' . $author->name . '" ' .
		'class="photo" />';

	// An author's name and image may or may not be links,
	// depending on whether or not he's the only author.
	if ($link) {
		$a_tag = '<a href="' . PathToRoot::get() . 'authors/view/' . $author->id . '">';
		$name = $a_tag . $name . '</a>';
		$img  = $a_tag . $img  . '</a>';
	}

?>

<div class="author">

	<h2><?php echo $name; ?></h2>

	<?php echo $img; ?>

	<p><?php echo $author->bio; ?></p>

	<?php if ($author->social_media) { ?>

		<div class="social-media">

			<?php if (!empty($author->facebook_username)) { ?>
				<a href="http://www.facebook.com/<?php echo $author->facebook_username; ?>">
					<img src="<?php echo PathToRoot::get(); ?>images/social-media/facebook.png" width="24" height="24" alt="Become <?php echo $author->name; ?>'s friend on Facebook" />
				</a>
			<?php } ?>

			<?php if (!empty($author->twitter_username)) { ?>
				<a href="http://www.twitter.com/<?php echo $author->twitter_username; ?>">
					<img src="<?php echo PathToRoot::get(); ?>images/social-media/twitter.png" width="24" height="24" alt="Follow <?php echo $author->name; ?> on Twitter" />
				</a>
			<?php } ?>

		</div>

	<?php } ?>

</div>
