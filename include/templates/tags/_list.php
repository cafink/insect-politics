<div id="tag-list">

	<h2>Popular Tags</h2>

	<ul>
		<?php
			foreach ($tags as $tag)
				echo '<li><a href="' . PathToRoot::get() . 'tags/view/' . $tag['id'] . '" class="tag">' . $tag['name'] . '</a> <span class="note">(' . $tag['count'] . ' post' . ($tag['count'] == 1 ? '' : 's') . ')</span></li>';
		?>
	</ul>

	<?php
		if ($more)
			echo '<a href="' . PathToRoot::get() . 'tags">more&hellip;</a>';
	?>

</div>
