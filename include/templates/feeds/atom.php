<?php echo '<?'; ?>xml version="1.0" encoding="UTF-8"?>
<feed xml:lang="en-US" xmlns="http://www.w3.org/2005/Atom">

	<id>http://<?php echo $_SERVER['SERVER_NAME'] . PathToRoot::get(); ?></id>
	<title><?php echo $GLOBALS['config']['site_name']; ?></title>
	<updated><?php echo date(DATE_ATOM, strtotime($posts[0]->timestamp)); ?></updated>
	<?php if (!empty($author)) { ?>
		<author>
			<name><?php echo $author->name; ?></name>
			<email><?php echo $author->email; ?></email>
		</author>
	<?php } ?>
	<rights><?php $copyright = new TemplateView('_copyright.php'); $copyright->display(); ?></rights>

	<?php foreach ($posts as $post) { ?>
		<entry>
			<id>http://<?php echo $_SERVER['SERVER_NAME'] . PathToRoot::get() . 'posts/' . $post->short_name; ?></id>
			<title><?php echo htmlentities($post->title); ?></title>
			<updated><?php echo date(DATE_ATOM, strtotime($post->timestamp)); ?></updated>
			<author>
				<name><?php echo $post->author->name; ?></name>
				<email><?php echo $post->author->email; ?></email>
			</author>
			<content type="html">
				<?php
					echo htmlentities($post->feed_body);
					if ($GLOBALS['config']['show_comments'])
						echo htmlentities('<p><a href="http://' . $_SERVER['SERVER_NAME'] . PathToRoot::get() . 'posts/' . $post->short_name . '#comments">Read the comments on this post</a></p>');
				?>
			</content>
			<published><?php echo date(DATE_ATOM, strtotime($post->timestamp)); ?></published>
		</entry>
	<?php } ?>

</feed>
