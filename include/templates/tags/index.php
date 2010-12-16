<div id="tags">

	<h1>Tags</h1>

	<?php

		$num_long_cols = count($tags) % $GLOBALS['config']['tag_columns'];

		$count = 0;
		for($col = 0; $col < $GLOBALS['config']['tag_columns']; $col++) {

			// I normally wouldn't use inline styling, but since the width is
			// dependent on a PHP config variable, I feel it's okay to calculate
			// it here, rather than doing it manually in the main stylesheet
			// (thus having the same value in two places).
			echo '<ul style="width:' . 100 / $GLOBALS['config']['tag_columns'] . '%">';

				$num_rows = floor(count($tags) / $GLOBALS['config']['tag_columns']);

				if ($col < $num_long_cols)
					$num_rows++;

				for ($row = 0; $row < $num_rows; $row++) {
					echo '<li><a href="' . PathToRoot::get() . 'tags/view/' . $tags[$count]->id . '" class="tag">' . $tags[$count]->name . '</a> <span class="note">(' . count($tags[$count]->posts) . ' post' . (count($tags[$count]->posts) == 1 ? '' : 's') . ')</span></li>';
					$count++;
				}

			echo '</ul>';
		}
	?>

</div>
