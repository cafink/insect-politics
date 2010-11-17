<?php
/**
 * Routing Table
 *
 * These rules are used by the Dispatcher to map from a URL to a controller,
 * action (function on the controller), and any additional parameters which
 * will be passed to the controller's action.  All loaded plugins will have
 * their routing rules automatically merged with the ones listed below.
 *
 * @author    Gabe Martin-Dempesy <gabe@mudbugmedia.com>
 * @copyright Copyright &copy; 2007 Mudbug Media
 * @package   Chitin
 * @subpackage Dispatcher
 * @version   $Id: routes.php 1688 2008-06-22 23:28:16Z seanbug $
 */

include_once 'lib/Dispatcher.php';

if (!isset($routes)) {
	$routes = array();
}

// Feed URLs
$routes[] = new ChitinRoute('rss', array('controller' => 'posts', 'action' => 'feed', 'type' => 'rss'));
$routes[] = new ChitinRoute('atom', array('controller' => 'posts', 'action' => 'feed', 'type' => 'atom'));
$routes[] = new ChitinRoute('posts/feed/:type', array('controller' => 'posts', 'action' => 'feed', 'type' => 'rss'), array('type' => 'rss|atom'));
$routes[] = new ChitinRoute(':controller/feed/:id/:type', array('action' => 'feed', 'type' => 'rss'), array('controller' => 'authors|tags', 'id' => '\d+', 'type' => 'rss|atom'));

// Comment form URL
$routes[] = new ChitinRoute('comments/add/:post_id', array('controller' => 'comments', 'action' => 'add'));

// Standard Chitin URLs
$routes[] = new ChitinRoute(':controller/:action/:id', array(), array('action' => 'edit|delete|view', 'id' => '\d+'));
$routes[] = new ChitinRoute(':controller/:action', array('action' => 'index'));

// Short URLs for posts: example.com/id instead of example.com/posts/view/id
$routes[] = new ChitinRoute(':id', array('controller' => 'posts', 'action' => 'view'));

?>
