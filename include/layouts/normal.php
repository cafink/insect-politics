<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php
			if (isset($page['title']))
				echo $page['title'] . ' | ';
			echo $GLOBALS['config']['site_name'];
		?>
	</title>
	<link href="<?php echo PathToRoot::get(); ?>styles/chitin.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo PathToRoot::get(); ?>styles/layout.css" rel="stylesheet" type="text/css" />
<?php if (isset($redir) && !empty($redir))
	echo '<meta http-equiv="refresh" content="4;url=' . $redir .'" />';
?>
</head>
<body<?php if (isset($page['onload'])) echo ' onload="'.$page['onload'].'"'; ?>>
	<?php
		echo '<div id="header">';
		if (is_null($GLOBALS['config']['logo']))
			echo '<h1><a href="' . PathToRoot::get() . '">' . $GLOBALS['config']['site_name'] . '</a></h1>';
		else
			echo '<a href="' . PathToRoot::get() . '">' .
			     '<img src="' . PathToRoot::get() . 'images/' . $GLOBALS['config']['logo']['filename'] .
			     '" width="' . $GLOBALS['config']['logo']['width'] .
			     '" height="' . $GLOBALS['config']['logo']['height'] .
			     '" alt="' . $GLOBALS['config']['site_name'] . '" /></a>';
		echo '</div><div id="content-' . (isset($page['sidebar']) ? 'sidebar-' : '') . 'wrapper"><div id="content"' . (isset($page['sidebar']) ? '' : ' class="no-sidebar"') . '>' . $page['content'] . '</div>';
		if (isset($page['sidebar']))
			echo $page['sidebar'];
		echo '</div>';
	?>
	<div id="footer">&copy; <?php echo $GLOBALS['config']['copyright']; ?></div>
</body>
</html>
