<div id="sidebar">
	<?php
		if ($show_authors)
			echo $authors;

		if ($show_feeds) {
			echo '<h2>Feed' . (count($GLOBALS['config']['feeds']) > 1 ? 's' : '' ) . '</h2>';
			echo '<img src="' . PathToRoot::get() . 'images/feed.png" id="feed-icon" />';
			echo $feeds;
		}

		if ($show_tags)
			echo '<h2>Popular Tags</h2>' . $tags;

		if ($show_comments)
			echo '<h2>Recent Comments</h2>' . $comments;
	?>
</div>
