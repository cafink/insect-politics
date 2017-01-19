<h1>Log In</h1>

<div id="login-form">

	<?php

		if (isset($error))
			echo '<p class="error">' . $error . '</p>';

		echo FormHelper::form_open();

			echo '<fieldset>';

			echo FormHelper::label(array('name' => 'email', 'text' => 'e-mail:'));
			echo FormHelper::text(array('name' => 'email'));

			echo FormHelper::label(array('name' => 'password', 'text' => 'password:'));
			echo FormHelper::password(array('name' => 'password'));

			echo FormHelper::submit(array('name' => 'submit', 'value' => 'Submit'));
		?>
		</fieldset>
	</form>
</div>
