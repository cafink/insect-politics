<!-- We already have the year in the correct format,
     but getting the month name requires doing something like this, anyway. -->
<h1>Posts from <?php echo date('F Y', strtotime($year . '/' . $month . '/01')); ?></h1>

<div id="posts">
	<?php
		foreach ($posts as $post)
			echo $post;
		echo $pager_html;
	?>
</div>
