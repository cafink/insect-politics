<div id="search">

	<h2>Search</h2>

	<?php echo FormHelper::form_open(array('action' => 'posts/search')); ?>
		<?php echo FormHelper::text(array('name' => 'search_terms', 'size' => '20')); ?>
		<button>Search</button>
	</form>

	via <a href="http://www.google.com">Google</a>

</div>
