<div id="archive">

	<h1>Archive</h1>

	<?php

		foreach ($years as $year => $months) {

			echo "<h2>{$year}</h2><ul>";

			foreach ($months as $month => $post_count) {
				echo "<li>{$month} ({$post_count})</li>";
			}

			echo '</ul>';
		}


		$num_long_cols = count($months) % $GLOBALS['config']['archive_columns'];

		$count = 0;
		for($col = 0; $col < $GLOBALS['config']['archive_columns']; $col++) {

			// I normally wouldn't use inline styling, but since the width is
			// dependent on a PHP config variable, I feel it's okay to calculate
			// it here, rather than doing it manually in the main stylesheet
			// (thus having the same value in two places).
			echo '<ul style="width:' . 100 / $GLOBALS['config']['archive_columns'] . '%">';

				$num_rows = floor(count($months) / $GLOBALS['config']['archive_columns']);

				if ($col < $num_long_cols)
					$num_rows++;

				for ($row = 0; $row < $num_rows; $row++) {
					echo '<li><a href="' . PathToRoot::get() . 'archive/view/' . $months[$count] . '">' . $months[$count] . '</a></li>';
					$count++;
				}

			echo '</ul>';
		}
	?>

</div>
