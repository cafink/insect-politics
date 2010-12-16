<div id="sidebar">
	<?php
		if ($show_authors)
			echo $authors;

		if ($show_search)
			echo '<h2>Search</h2>' . $search;

		if ($show_feeds)
			echo '<h2>Feeds</h2>' . $feeds;

		if ($show_tags)
			echo '<h2>Popular Tags</h2>' . $tags;

		if ($show_comments)
			echo '<h2>Recent Comments</h2>' . $comments;

		if ($show_archive)
			echo '<h2>Archive</h2>' . $archive;
	?>
</div>
