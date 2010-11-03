<div id="sidebar">
	<?php
		if ($show_authors)
			echo $authors;
		if ($show_tags)
			echo '<h2>Popular Tags</h2>' . $tags;
		if ($show_comments)
			echo '<h2>Recent Comments</h2>' . $comments;
	?>
</div>