<div id="archive-list">

	<h2>Archive</h2>

	<ul>
		<?php

			$count = 0;
			$more = false;
			foreach ($years as $year => $months) {
				foreach ($months as $month => $post_count) {
					if ($count++ >= $GLOBALS['config']['sidebar_archive_limit']) {
						$more = true;
						break 2;
					}
					echo '<li><a href="' . PathToRoot::get() . 'archive/view/' . $year . '/' . $month . '">' . date('F Y', strtotime($year . '/' . $month . '/01')) . ' (' . $post_count . ' post' . ($post_count == 1 ? '' : 's') . ')</a></li>';
				}
			}
		?>
	</ul>

	<?php
		if ($more)
			echo '<a href="' . PathToRoot::get() . 'archive">more&hellip;</a>';
	?>

</div>
