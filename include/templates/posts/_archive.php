<ul>
	<?php
		foreach ($months as $month)
			// strtotime() can't figure out how to turn YYYY/MM into a timestamp,
			// but it can YYYY/MM/DD, hence the "/01" at the end.
			echo '<li><a href="#">' . date('F Y', strtotime($month . '/01')) . '</a></li>';
	?>
</ul>
