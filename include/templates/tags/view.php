<div id="posts">

	<h1>Posts tagged &ldquo;<?php echo $tag->name; ?>&rdquo;</h1>

	<?php
		foreach ($tag->posts as $post)
			echo $post;
		echo $pager_html;
	?>
</div>
