<?php

include_once 'models/Post.php';

class PostsController extends ApplicationController {

	function index ($coords) {

		list($all_posts, $this->pager_html) = $this->paginate('Post');

		$this->posts = array();
		foreach($all_posts as $post) {
			$post_view = new TemplateView('posts/_post.php');
			$post_view->assign('post', $post);
			$this->posts[] = $post_view->getOutput();
		}

		$this->page['sidebar'] = $this->sidebar();
		$this->render();
	}

	function view ($coords) {

		if (is_numeric($coords['id']))
			$this->post = PostTable()->get($coords['id']);
		else
			$this->post = PostTable()->find(array('fields' => 'short_name', 'values' => $coords['id'], 'first' => true));

		if (empty($this->post))
			$this->redirect('posts');

		// An author's name should not link to a list of his posts
		// if he is the only author.
		$this->link = AuthorTable()->multiple();

		if ($GLOBALS['config']['show_comments']) {

			$comments = $this->post->comments;
			$comment_views = array();
			foreach ($comments as $comment) {
				$comment_view = new TemplateView('comments/_comment.php');
				$comment_view->assign('comment', $comment);
				$comment_view->assign('link', $this->link);
				$comment_views[] = $comment_view->getOutput();
			}

			$comment_form_view = new TemplateView('comments/_form.php');
			$comment_form_view->assign('post', $this->post);

			$comments_view = new TemplateView('comments/_comments.php');
			$comments_view->assign('comments', $comment_views);
			$comments_view->assign('comment_pending', isset($_GET['comment-pending']));
			$comments_view->assign('comment_form', $comment_form_view->getOutput());
			$this->comments = $comments_view->getOutput();
		}

		$this->page['sidebar'] = $this->sidebar(array(
			'author' => $this->post->author,
			'tags'   => $this->post->tags
		));
		$this->page['title'] = $this->post->title;
		$this->page['keywords'] = $this->post->tag_list;
		$this->render();
	}

	// Feed of all posts
	function feed ($coords) {

		$this->posts = PostTable()->find();

		if (!AuthorTable()->multiple())
			$this->author = AuthorTable()->find(array('first' => true));

		$this->page['layout'] = false;
		$this->render(array('file' => "feeds/{$GLOBALS['config']['feed']}.php"));

	}

	// This doesn't seem like the ideal place for this search function
	// (after all, it doesn't search only posts), but it's as good as any.
	// Or should there be a dedicated search controller?
	function search ($coords) {
		// Just redirect to Google using the "site:" operator
		// @todo: Add real search support
		$this->redirect(
			!empty($_POST['search_terms']) ?
			'http://www.google.com/search?q=' . urlencode($_POST['search_terms']) . '+site:' . $_SERVER['HTTP_HOST'] . PathToRoot::get() :
			'posts'
		);
	}
}

?>
