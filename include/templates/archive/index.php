<div id="archive">

	<h1>Archive</h1>

	<?php

		foreach ($years as $year => $months) {

			echo '<div class="archive-year"><h2>' . $year . '</h2><ul>';

			foreach ($months as $month => $post_count) {
				echo '<li><a href="' . PathToRoot::get() . 'archive/view/' . $year . '/' . $month . '">' . date('F', strtotime($year . '/' . $month . '/01')) . ' (' . $post_count . ' post' . ($post_count == 1 ? '' : 's') . ')</a></li>';
			}

			echo '</ul></div>';
		}
	?>

</div>
