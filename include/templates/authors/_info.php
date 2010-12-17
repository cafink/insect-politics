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

	<?php
		if ($author->social_media) {

			echo '<div class="social-media">';

			if (!empty($author->facebook_username)) {

				// @todo: There must be a better way to handle this logic!
				$class = 'first';
				if (empty($author->twitter_username))
					$class .= ' last';

				echo '<a href="http://www.facebook.com/' . $author->facebook_username . '">';
				echo '<img src="' . PathToRoot::get() . 'images/social-media/facebook.png" width="24" height="24" class="' . $class . '" alt="Become ' . $author->name . '\'s friend on Facebook" />';
				echo '</a>';
			}

			if (!empty($author->twitter_username)) {

				$class = 'last';
				if (empty($author->facebook_username))
					$class = 'first ' . $class;

				echo '<a href="http://www.twitter.com/' . $author->twitter_username . '">';
				echo '<img src="' . PathToRoot::get() . 'images/social-media/twitter.png" width="24" height="24" class="' . $class . '" alt="Follow ' . $author->name . ' on Twitter" />';
				echo '</a>';
			}

			echo '</div>';
		}
	?>

</div>
