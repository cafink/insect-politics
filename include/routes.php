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

// Comment form URL
$routes[] = new ChitinRoute('comments/add/:post_id', array('controller' => 'comments', 'action' => 'add'));

// Archive year/month URL
// @todo: regex for year & month
$routes[] = new ChitinRoute('archive/view/:year/:month', array('controller' => 'archive', 'action' => 'view'));

// Standard Chitin URLs
$routes[] = new ChitinRoute(':controller/:action/:id', array(), array('action' => 'edit|delete|view|feed', 'id' => '\d+'));
$routes[] = new ChitinRoute(':controller/:action', array('action' => 'index'));

?>
