<?php

include_once 'models/Author.php';

class ApplicationController extends BaseController {

	protected function sidebar ($params = array()) {

		// Default values
		if (!isset($params['show_authors']))
			$params['show_authors'] = true;
		if (!isset($params['show_feeds']))
			$params['show_feeds'] = true;
		if (!isset($params['show_tags']))
			$params['show_tags'] = true;
		if (!isset($params['show_comments']))
			$params['show_comments'] = true;

		// Author(s)
		if ($params['show_authors']) {

			// If an author is specified, or there is only one author in the first place,
			// just use the single-author template.
			if (!AuthorTable()->multiple() || isset($params['author']) || isset($params['author_id']))
				$author_file = 'authors/_info.php';
			else
				$author_file = 'authors/_multi_info.php';

			$author_view = new TemplateView($author_file);

			if (!AuthorTable()->multiple())
				$author_view->assign('author', AuthorTable()->find(array('first' => true)));
			elseif (isset($params['author']))
				$author_view->assign('author', $params['author']);
			elseif (isset($params['author_id']))
				$author_view->assign('author', AuthorTable()->get($params['author_id']));
			else
				$author_view->assign('authors', AuthorTable()->find());

			// An author's bio in the sidebar should not link to a list of his posts
			// if he is the only author.
			$author_view->assign('link', AuthorTable()->multiple());

			$authors = $author_view->getOutput();
		} else {
			$authors = null;
		}

		// Make sure we have feeds to display in the first place.
		if (!$GLOBALS['config']['feeds'])
			$params['show_feeds'] = false;

		// Feeds
		if ($params['show_feeds']) {
			$feed_view = new TemplateView('feeds/_list.php');
			$feeds = $feed_view->getOutput();
		} else {
			$feeds = null;
		}

		// Tags
		if ($params['show_tags']) {
			$tag_view = new TemplateView('tags/_list.php');

			list($tags, $more) = TagTable()->popular();

			$tag_view->assign('tags', $tags);
			$tag_view->assign('more', $more);
			$tags = $tag_view->getOutput();
		} else {
			$tags = null;
		}

		// Unlike authors and tags, comments can be
		// disabled altogether via a config variable.
		if (!$GLOBALS['config']['show_comments'])
			$params['show_comments'] = false;

		// Comments
		if ($params['show_comments']) {
			$comment_view = new TemplateView('comments/_list.php');
			$comment_view->assign('comments', CommentTable()->scope('approved')->find(array(
				'page'            => 1,
				'per_page'        => $GLOBALS['config']['sidebar_comment_limit'],
				'sort_fields'     => 'created',
				'sort_directions' => 'DESC',
			)));
			$comments = $comment_view->getOutput();
		} else {
			$comments = null;
		}

		$view = new TemplateView('sidebar.php');

		$view->assign('show_authors', $params['show_authors']);
		$view->assign('authors', $authors);
		$view->assign('show_feeds', $params['show_feeds']);
		$view->assign('feeds', $feeds);
		$view->assign('show_tags', $params['show_tags']);
		$view->assign('tags', $tags);
		$view->assign('show_comments', $params['show_comments']);
		$view->assign('comments', $comments);
		return $view->getOutput();
	}
}

?>
