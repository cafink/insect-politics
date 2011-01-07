<div id="preview">

	<h3>Preview Your Comment</h3>

	<div>
		<?php
			// @todo: Abstract this code, which is identical to the code that displays comments proper,
			//        into a separate template, adhering to the DRY principle.
			$body = is_null($GLOBALS['config']['comment_html']) ? htmlentities($comment->body) : strip_tags($comment->body, $GLOBALS['config']['comment_html']);
			echo str_replace("\n", '<br />', $body);
		?>
	</div>

</div>
