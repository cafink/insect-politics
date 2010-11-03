<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
	<channel>

		<title><?php echo $GLOBALS['config']['site_name']; ?></title>
		<link>http://<?php echo $_SERVER['SERVER_NAME']; ?></link>
		<description><?php echo $GLOBALS['config']['site_name']; ?> blog</description>
		<lastBuildDate><?php echo date(DATE_RSS, strtotime($posts[0]->timestamp)); ?></lastBuildDate>
		<language>en-us</language>

		<?php foreach ($posts as $post) { ?>
			<item>
				<title><?php echo $post->title; ?></title>
				<link>http://<?php echo $_SERVER['SERVER_NAME'] . PathToRoot::GET() . $post->short_name; ?></link>
				<guid isPermaLink="false"><?php echo $post->short_name; ?></guid>
				<pubdate><?php echo date(DATE_RSS, strtotime($post->timestamp)); ?></pubdate>
				<?php echo $post->body; ?>
			</item>
		<?php } ?>

	</channel>
</rss>
