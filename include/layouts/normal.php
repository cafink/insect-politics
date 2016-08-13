<?php echo '<?'; ?>xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<?php

			if (isset($page['description']))
				echo '<meta name="description" content="' . $page['description'] . '" />';

			if (isset($page['keywords'])) {
				if (is_array($page['keywords']))
					$page['keywords'] = implode(', ', $page['keywords']);
				echo '<meta name="keywords" content="' . $page['keywords'] . '" />';
			}

		?>

		<title>
			<?php
				if (isset($page['title']))
					echo strip_tags($page['title']) . ' | ';
				echo $GLOBALS['config']['site_name'];
			?>
		</title>

		<link href="<?php echo PathToRoot::get(); ?>styles/chitin.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo PathToRoot::get(); ?>styles/layout.css" rel="stylesheet" type="text/css" />

		<?php
			if (isset($redir) && !empty($redir))
				echo '<meta http-equiv="refresh" content="4;url=' . $redir .'" />';
		?>

		<?php

			if (isset($page['script']))
				$page['scripts'] = $page['script'];

			if (isset($page['scripts'])) {

				if (!is_array($page['scripts']))
					$page['scripts'] = array($page['scripts']);

				foreach ($page['scripts'] as $script)
					echo '<script type="text/javascript" src="' . PathToRoot::get() . 'js/' . $script . '"></script>';
			}
		?>

	</head>

	<body<?php if (isset($page['onload'])) echo ' onload="'.$page['onload'].'"'; ?>>

		<div id="header">
			<div id="logo">
				<a href="<?php echo PathToRoot::get(); ?>">
					<?php
						if (is_null($GLOBALS['config']['logo']))
							echo $GLOBALS['config']['site_name'];
						else
							echo '<img src="' . PathToRoot::get() . 'images/' . $GLOBALS['config']['logo']['filename'] .
								 '" width="' . $GLOBALS['config']['logo']['width'] .
								 '" height="' . $GLOBALS['config']['logo']['height'] .
								 '" alt="' . $GLOBALS['config']['site_name'] . '" />';
					?>
				</a>
			</div>
		</div>

		<?php $has_sidebar = isset($page['sidebar']); ?>

		<div id="content-<?php echo $has_sidebar ? 'sidebar-' : ''; ?>wrapper">

			<div id="content"<?php echo $has_sidebar ? '' : ' class="no-sidebar"'; ?>>
				<?php echo $page['content']; ?>
			</div>

			<?php
				if ($has_sidebar)
					echo $page['sidebar'];
			?>

		</div>

		<div id="footer"><?php $copyright = new TemplateView('_copyright.php'); $copyright->display(); ?></div>

	</body>
</html>
