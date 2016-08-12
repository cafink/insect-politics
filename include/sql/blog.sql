CREATE TABLE IF NOT EXISTS `authors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`name` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`bio` text NOT NULL,
	`facebook_username` varchar(255) DEFAULT NULL,
	`twitter_username` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `comments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`author_id` int(11) DEFAULT NULL,
	`post_id` int(11) NOT NULL,
	`name` varchar(255) DEFAULT NULL,
	`email` varchar(255) DEFAULT NULL,
	`homepage` varchar(255) DEFAULT NULL,
	`ip` varchar(255) DEFAULT NULL,
	`body` text NOT NULL,
	`timestamp` timestamp NOT NULL,
	`spam` boolean NOT NULL,
	`status` enum('pending','approved','rejected') NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`author_id` int(11) NOT NULL,
	`short_name` varchar(255) NOT NULL,
	`title` varchar(255) NOT NULL,
	`body` text NOT NULL,
	`timestamp` timestamp NOT NULL,
	`additional_views` int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `posts_tags_map` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`post_id` int(11) NOT NULL,
	`tag_id` int(11) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tags` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `views` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`post_id` int(11) NOT NULL,
	`ip` varchar(255) DEFAULT NULL,
	`user_agent` varchar(255) DEFAULT NULL,
	`count` int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
