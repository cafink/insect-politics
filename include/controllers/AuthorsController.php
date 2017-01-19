<?php

include_once 'models/Author.php';
include_once 'views/XmlTemplateView.php';

class AuthorsController extends ApplicationController {

	function view ($coords) {

		$this->author = AuthorTable()->get($coords['id']);

		// We already have $this->author->posts, but we can't as easily paginate that.
		list($author_posts, $this->pager_html) = $this->paginate('Post', 'author_id = ?', array($coords['id']));

		$this->posts = array();
		foreach($author_posts as $post) {
			$post_view = new TemplateView('posts/_post.php');
			$post_view->assign('post', $post);
			$this->posts[] = $post_view->getOutput();
		}

		$this->page['sidebar'] = $this->sidebar(array('author' => $this->author));
		$this->page['title'] = $this->author->name;
		$this->render();
	}

	// Feed of one author's posts
	function feed ($coords) {

		$this->author = AuthorTable()->get($coords['id']);
		$this->posts = $this->author->posts;

		header("Content-Type: text/xml");
		$this->page['layout'] = false;
		$this->render(array('file' => "feeds/{$GLOBALS['config']['feed']}.php"));
	}

	function login ($coords) {

		if (isset($_POST['submit'])) {

			$user = AuthorTable()->find(array(
				'fields' => 'email',
				'values' => $_POST['email'],
				'first'  => true
			));

			if (is_null($user)) {

				$this->error = 'Invalid credentials';

			} else {

				$auth = new \pmill\Auth\Authenticate;

				try {

					$auth->login($user, $_POST['password']);
					$this->redirect('posts/');

				} catch(\pmill\Auth\Exceptions\PasswordException $e) {

					$this->error = 'Invalid credentials';

				}
			}
		}

		$this->render();
	}

	function logout ($coords) {
		$auth = new \pmill\Auth\Authenticate;
		$auth->logout();
		$this->redirect('posts/');
	}
}

?>
