<div id="author-posts">

	<h1>Posts by <?php echo $author->name; ?></h1>

	<?php
		foreach ($posts as $post)
			echo $post;
		echo $pager_html;
	?>
</div>
