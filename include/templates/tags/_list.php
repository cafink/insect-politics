<div id="tag-list">
	<ul>
		<?php
			foreach ($tags as $tag)
				echo '<li><a href="' . PathToRoot::get() . 'tags/view/' . $tag->id . '" class="tag">' . $tag->name . '</a> <span class="note">(' . count($tag->posts) . ' post' . (count($tag->posts) == 1 ? '' : 's') . ')</span></li>';
		?>
	</ul>
	<?php
		if ($more)
			echo '<a href="' . PathToRoot::get() . 'tags">more&hellip;</a>';
	?>
</div>