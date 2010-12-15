<h1>Posts by <?php echo $author->name; ?></h1>

<div id="author-posts">
	<?php
		foreach ($posts as $post)
			echo $post;
		echo $pager_html;
	?>
</div>
