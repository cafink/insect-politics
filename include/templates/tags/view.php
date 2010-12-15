<h2>Posts tagged &ldquo;<?php echo $tag->name; ?>&rdquo;</h2>
<div id="posts">
	<?php
		foreach ($tag->posts as $post)
			echo $post;
		echo $pager_html;
	?>
</div>
