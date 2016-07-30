<?php
/**
 * Configuration variables
 *
 * This file is included by init.php, thus its array is available on
 * every dynamic page.  When referencing this array, you should refer to it as
 * $GLOBALS['config']
 *
 * @author    Gabe Martin-Dempesy <gabe@mudbugmedia.com>
 * @copyright Copyright &copy; 2005 Mudbug Media
 * @package   Chitin
 * @version   $Id: config.php 3802 2009-04-08 20:40:51Z gabebug $
 */

// Configuration Options
$config = array();

$config['site_name'] = 'Insect Politics';

/**
 * This variable is set in the profile
 * @var string DSN formatted for PEAR's DB
 * @see http://pear.php.net/manual/en/package.database.db.intro-dsn.php
 */
$config['dsn'] = 'mysql://username:password@localhost/blog';

/**
 * Unix Zoneinfo file
 *
 * Setting this will update the entire environment as well as MySQL connections
 * Leaving this unset will default to /etc/localtime
 */
//$config['time_zone'] = 'US/Central';

/**
 * Layout Files
 * @todo: Mobile layout
 */
$config['layouts'] = array();
$config['layouts']['normal'] = 'layouts/normal.php';

/**
 * Default options for use with the Chitin Pager class
 *
 * @link https://wiki.mudbugmedia.com/index.php/Chitin_Pager
 */
$config['pager'] = array();

// Null for no logo
$config['logo'] = null; /*array(
	'filename' => 'insect_politics.png',
	'width'    => 884,
	'height'   => 88
);*/

$config['copyright_holder'] = 'Carl Fink';

// Date displayed for each post
$config['date_format'] = 'F jS, Y';

// How posts and comments are timestamped in the database
$config['timestamp_format'] = 'Y-m-d H:i:s';

// Author images for the sidebar
$config['author_img'] = array(
	'width'  => 192,
	'height' => 128
);

// Whether or not readers may submit new comments
$config['enable_comments'] = true;

// Whether or not existing comments are displayed
// If enable_comments is true, then show_comments must also be true!
// The behavior when show_comments is false but enable_comments is true is undefined.
$config['show_comments'] = true;

$config['comment_order'] = 'ASC';

// Display e-mail address for comments
// If false, an "e-mail address will not be displayed" message appears
// in the comment form, so beware of enabling this later!
$config['comment_display_email'] = false;

// Whether or not comments are accepted for older articles,
$config['comments_expire'] = false;

// How long (in seconds) to accept comments if the above is true.
$config['comment_expiration'] = 30 * 24 * 60 * 60;

// The number of characters displayed in a sidebar comment snippet
$config['comment_snippet_length'] = 64; // in characters

// If true, comments will go into the database with status "pending."
// Currently, they must be approved by manually changing that value in the database.
$config['approve_comments'] = false;

// If use_snippets is true, a snippet will be displayed on the home page for any
// post that has one (posts that don't have snippets will display in their entirety).
// If it's false, the entire post will be displayed, regardless of whether or
// not a post has a snippet.
$config['use_snippets'] = true;

// The snippet marker is simply found in and removed from the text by the Post
// Model.  The snippet should be well-formed, so don't put the marker
// inside any elements.
$config['snippet_marker'] = '{snip}';

// Number of popular tags, recent comments, and archive months to display in the sidebar
$config['sidebar_tag_limit']     = 3;
$config['sidebar_comment_limit'] = 4;
$config['sidebar_archive_limit'] = 5;

// Number of columns in which to display tags & archive months on index pages
$config['tag_columns'] = 3;
$config['archive_columns'] = 3;

// "rss" or "atom," or null for no feed
$config['feed'] = 'rss';

// API key for Akismet spam detection
$config['akismet_key'] = '';

?>
