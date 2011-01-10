<?php

include_once 'models/Comment.php';

// @todo: Feed of comments?

class CommentsController extends ApplicationController {

	function add ($coords) {

		$this->post = PostTable()->get($coords['post_id']);

		$errors = array();
		$error_content = '';

		if (isset($_POST['submit'])) {

			$this->comment = new Comment($_POST);

			$errors = $this->comment->validate('INSERT');

			if (empty($errors)) {

				if ($_POST['submit'] == 'Preview') {

					$preview_view = new TemplateView('comments/_preview.php');
					$preview_view->assign('comment', $this->comment);
					$this->preview = $preview_view->getOutput();

				} else {

					$this->comment->save();

					// @todo: Check whether special characters need escaping here
					$message = 'A reader has commented on the post "' . $this->post->title . '" (http' . (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on') ? 's' : '' ) . "://". $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/posts/view/' . $this->post->id . '#comment-' . $this->comment->id . ').';
					mail($this->post->author->email, 'New Comment', $message, "From: webmaster@{$_SERVER['HTTP_HOST']}");

					$append = $GLOBALS['config']['approve_comments'] ?
						'?comment-pending=true#comments' :
						'#comment-' . $this->comment->id;

					$this->redirect('posts/view/' . $this->post->id . $append);
				}


			} else {
				$error_view = new TemplateView('error/list.php');
				$error_view->assign('errors', $errors);
				$error_content = $error_view->getOutput();
			}
		}

		$comment_form_view = new TemplateView('comments/_form.php');
		$comment_form_view->assign('post', $this->post);
		$comment_form_view->assign('errors', $errors);
		$comment_form_view->assign('defaults', $_POST);
		$comment_form_view->assign('error_content', $error_content);
		$this->comment_form = $comment_form_view->getOutput();

		$page['title'] = $this->post->title;
		$this->render();
	}
}

?>
