<div class="author">

	<h2>
		<a href="<?php echo PathToRoot::get(); ?>authors/view/<?php echo $author->id; ?>">
			<?php echo $author->name; ?>
		</a>
	</h2>

	<a href="<?php echo PathToRoot::get(); ?>authors/view/<?php echo $author->id; ?>">
		<img
			src="<?php echo PathToRoot::get(); ?>images/authors/<?php echo $author->images['small']; ?>"
			width="<?php echo $GLOBALS['config']['img']['small']['width']; ?>"
			height="<?php echo $GLOBALS['config']['img']['small']['height']; ?>"
			alt="<?php echo $author->name; ?>"
			class="photo"
		/>
	</a>

	<p><?php echo $author->short_bio; ?></p>

	<?php
		if (!empty($author->facebook_username) || !empty($author->twitter_username)) {

			echo '<div class="social-media">';

			if (!empty($author->facebook_username)) {

				//  @todo:  There must be a better way to handle this logic!
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
