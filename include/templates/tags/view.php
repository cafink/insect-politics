<h2>Posts tagged &ldquo;<?php echo $tag->name; ?>&rdquo;</h2>
<div id="posts">
	<?php
		foreach ($tag->posts as $post)
			include 'include/templates/posts/_post.php';
		echo $pager_html;
	?>
</div>
