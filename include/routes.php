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
$routes[] = new ChitinRoute(':controller/:action/:id', array(), array('action' => 'edit|delete|view', 'id' => '\d+'));
$routes[] = new ChitinRoute(':controller/:action', array('action' => 'index'));

// Feed URLs
$routes[] = new ChitinRoute('rss', array('controller' => 'feeds', 'action' => 'index', 'type' => 'rss'));
$routes[] = new ChitinRoute('atom', array('controller' => 'feeds', 'action' => 'index', 'type' => 'atom'));
$routes[] = new ChitinRoute('feeds/:type', array('controller' => 'feeds', 'action' => 'index'));

// Short URLs for posts: example.com/id instead of example.com/posts/view/id
$routes[] = new ChitinRoute(':id', array('controller' => 'posts', 'action' => 'view'));

$routes[] = new ChitinRoute('comments/add/:post_id', array('controller' => 'comments', 'action' => 'add'));

?>
