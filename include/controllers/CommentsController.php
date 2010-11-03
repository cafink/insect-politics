<?php

include_once 'models/Comment.php';

class CommentsController extends ApplicationController {

	function add ($coords) {

		$this->post = PostTable()->get($coords['post_id']);

		$errors = array();
		$error_content = '';

		if (isset($_POST['submit'])) {

			$comment = new Comment($_POST);

			if ($comment->save()) {
				$message = 'A reader has commented on the post "' . $this->post->title . '" (http' . (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on') ? 's' : '' ) . "://". $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/posts/view/' . $this->post->id . '#comment-' . $comment->id . ').';
				mail($this->post->author->email, 'New Comment', $message, "From: webmaster@{$_SERVER['HTTP_HOST']}");

				if ($GLOBALS['config']['approve_comments'])
					$append = '?comment-pending=true#comments';
				else
					$append = '#comment-' . $comment->id;

				header('Location: ' . PathToRoot::get() . 'posts/view/' . $this->post->id . $append);
				die();
			} else {
				$errors = $comment->getErrors();
				$error_view = new TemplateView('error/list.php');
				$error_view->assign('errors', $errors);
				$error_content = $error_view->getOutput();
			}
		}

		$comment_form_view = new TemplateView('comments/_form.php');
		$comment_form_view->assign('post', $this->post);
		$comment_form_view->assign('errors', $errors);
		$comment_form_view->assign('error_content', $error_content);
		$this->comment_form = $comment_form_view->getOutput();

		$page['title'] = $this->post->title;
		$this->render();
	}
}

?>
