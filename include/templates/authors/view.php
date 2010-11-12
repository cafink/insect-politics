<h1>Posts by <?php echo $author->name; ?></h1>

<div id="author-posts">
	<?php
		foreach ($posts as $post)
			include 'templates/posts/_post.php';
		echo $pager_html;
	?>
</div>
