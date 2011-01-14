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
// The normal :controller/:action/:id route would suffice here,
// but we want to use :post_id instead of :id.
$routes[] = new ChitinRoute('comments/add/:post_id', array('controller' => 'comments', 'action' => 'add'), array('id' => '\d+'));

// Archive year/month URL
// Allow years 1970-2037, months 01-12
$routes[] = new ChitinRoute('archive/view/:year/:month', array('controller' => 'archive', 'action' => 'view'), array('year' => '(?:19[789]\d|20(?:[012]\d|3[0-7]))', 'month' => '(?:0[1-9]|1[012])'));

// Allow tag URLs without the "view" component, and allow strings in the ID component,
// so we can use the tag name instead of ID number.
$routes[] = new ChitinRoute('tags/:action/:id', array('controller' => 'tags'));
$routes[] = new ChitinRoute('tags/index', array('controller' => 'tags', 'action' => 'index'));
$routes[] = new ChitinRoute('tags/:id', array('controller' => 'tags', 'action' => 'view'));

// Standard Chitin URLs
$routes[] = new ChitinRoute(':controller/:action/:id', array(), array('action' => 'edit|delete|view|feed', 'id' => '\d+'));
$routes[] = new ChitinRoute(':controller/:action', array('action' => 'index'));

?>
