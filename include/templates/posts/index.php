<div id="posts">
	<?php
		foreach ($posts as $post)
			include '_post.php';
		echo $pager_html;
	?>
</div>
