<h1>Tags</h1>

<div id="tags">
	<ul>
		<?php
			foreach ($tags as $tag) {
				echo '<li><a href="' . PathToRoot::get() . 'tags/view/' . $tag->id . '" class="tag">' . $tag->name . '</a> <span class="note">(' . count($tag->posts) . ' post' . (count($tag->posts) == 1 ? '' : 's') . ')</span></li>';
			}
		?>
	</ul>
</div>
