<!-- @todo: Javascript validation -->

<div id="comment-form">

	<h3>Add a Comment</h3>

	<?php

		if (!empty($error_content)) echo '<div class=\'errorlistview\'>' . $error_content . '</div>';

		echo FormHelper::form_open(array('action' => 'comments/add/' . $post->id . '#comment-area'));

			echo '<fieldset>';

			echo FormHelper::label(array('name' => 'name', 'text' => 'name:'));
			echo FormHelper::text(array('name' => 'name'));

			$email_text = 'e-mail address';
			if (!$GLOBALS['config']['comment_display_email'])
				$email_text .= ' <span class="note">(will not be displayed publicly)</span>';
			echo FormHelper::label(array('name' => 'email', 'text' => $email_text . ':'));
			echo FormHelper::text(array('name' => 'email'));

			echo FormHelper::label(array('name' => 'homepage', 'text' => 'homepage:'));
			echo FormHelper::text(array('name' => 'homepage'));

			$comment_text = 'comment';
			$comment_text .= ' <span class="note">(you may style your comment with <a href="https://daringfireball.net/projects/markdown/">Markdown</a>)</span>';
			echo FormHelper::label(array('name' => 'body', 'text' => $comment_text . ':'));
			echo FormHelper::textarea(array('name' => 'body', 'rows' => 8, 'cols' => 40));

			echo FormHelper::hidden(array('name' => 'post_id', 'value' => $post->id));

			echo FormHelper::submit(array('name' => 'submit', 'value' => 'Preview'));
			echo FormHelper::submit(array('name' => 'submit', 'value' => 'Submit'));
		?>
		</fieldset>
	</form>
</div>
