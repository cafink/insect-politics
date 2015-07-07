<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>

		<title><?php echo $GLOBALS['config']['site_name']; ?></title>
		<link>http://<?php echo $_SERVER['SERVER_NAME'] . PathToRoot::get(); ?></link>
		<description><?php echo $GLOBALS['config']['site_name']; ?> blog</description>
		<language>en-us</language>
		<copyright><?php $copyright = new TemplateView('_copyright.php'); $copyright->display(); ?></copyright>
		<?php if (!empty($author)) { ?>
			<managingEditor><?php echo $author->email; ?></managingEditor>
		<?php } ?>
		<lastBuildDate><?php echo date(DATE_RSS, strtotime($posts[0]->timestamp)); ?></lastBuildDate>

		<?php foreach ($posts as $post) { ?>
			<item>
				<title><?php echo htmlentities($post->title); ?></title>
				<link>http://<?php echo $_SERVER['SERVER_NAME'] . PathToRoot::get() . $post->short_name; ?></link>
				<description>
					<?php
						echo htmlentities(
							$post->feed_body .
							'<p><a href="http://' . $_SERVER['SERVER_NAME'] . PathToRoot::get() . 'posts/' . $post->short_name . '#comments">Read the comments on this post</a></p>'
						);
					?>
				</description>
				<author><?php echo $post->author->email; ?></author>
				<comments>http://<?php echo $_SERVER['SERVER_NAME'] . PathToRoot::get() . $post->short_name; ?>#comments</comments>
				<guid isPermaLink="false"><?php echo $post->short_name; ?></guid>
				<pubDate><?php echo date(DATE_RSS, strtotime($post->timestamp)); ?></pubDate>
			</item>
		<?php } ?>

	</channel>
</rss>
