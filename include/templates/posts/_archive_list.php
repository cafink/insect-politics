<div id="archive-list">

	<h2>Archive</h2>

	<ul>
		<?php
			foreach ($months as $month)
				// strtotime() can't figure out how to turn YYYY/MM into a timestamp,
				// but it can YYYY/MM/DD, hence the "/01" at the end.
				echo '<li><a href="' . PathToRoot::get() . 'posts/archive/' . $month . '">' . date('F Y', strtotime($month . '/01')) . '</a></li>';
		?>
	</ul>

</div>
