<div id="feed-list">
	<ul>
		<?php
			foreach ($GLOBALS['config']['feeds'] as $feed => $name)
				echo '<li><a href="' . PathToRoot::get() . 'feeds/' . $feed . '">' . $name . '</a></li>';
		?>
	</ul>
</div>
