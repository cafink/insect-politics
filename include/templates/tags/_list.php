<div id="tag-list">

	<h2>Popular Tags</h2>

	<ul>
		<?php
			foreach ($tags as $tag)
				echo '<li><a href="' . PathToRoot::get() . 'tags/' . $tag->link_name . '" class="tag">' . $tag->name . '</a> <span class="note">(' . count($tag->posts) . ' post' . (count($tag->posts) == 1 ? '' : 's') . ')</span></li>';
		?>
	</ul>

	<?php
		if ($more)
			echo '<a href="' . PathToRoot::get() . 'tags">more&hellip;</a>';
	?>

</div>
