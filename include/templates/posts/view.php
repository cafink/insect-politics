<div id="prev-next">
	<?php

		if (!is_null($post->prev))
			echo '<a id="prev" href="' . PathToRoot::get() . 'posts/' . $post->prev->short_name . '">' . $post->prev->title . '</a>';
		if (!is_null($post->next))
			echo '<a id="next" href="' . PathToRoot::get() . 'posts/' . $post->next->short_name . '">' . $post->next->title . '</a>';

	?>
</div>

<div id="post" class="post">

	<h1><?php echo $post->title; ?></h1>

	<div class="byline">
		by
		<?php
			$name = $post->author->name;
			if ($link)
				$name = '<a href="' . PathToRoot::get() . 'authors/view/' . $post->author->id . '">' . $name . '</a>';
			echo $name;
		?>
	</div>

	<?php

		echo '<div class="timestamp">' . date($GLOBALS['config']['date_format'], strtotime($post->timestamp)) . '</div>';

		echo $post->body;

		if (!empty($post->tags)) {

			echo '<div id="post-tags">';

			$count = 0;
			$first = true;
			$last = false;
			foreach ($post->tags as $tag) {
				$count++;

				if ($count == count($post->tags))
					$last = true;

				$class = 'tag';
				if ($first)
					$class .= ' first';
				if ($last)
					$class .= ' last';

				// Zero-width space (&#8203;) used to separate words (instead of no space),
				// so that the text-transform: capitalize; style may be applied.
				echo '<a href="' . PathToRoot::get() . 'tags/' . $tag->link_name . '" class="' . $class . '">' . $tag->name . '</a>&#8203;';
				$first = false;
			}

			echo '</div>';
		}
	?>

</div>

<?php if ($GLOBALS['config']['show_comments']) { ?>
	<div id="comments"></div>
	<script type="text/jsx">
		var CommentList = React.createClass({
			render: function() {
				var commentNodes = this.props.data.map(function (comment) {
					return (
						<Comment author={comment.author}>
							{comment.text}
						</Comment>
					);
				});
				return (
					<div className="commentList">
						{commentNodes}
					</div>
				);
			}
		});

		var Comment = React.createClass({
			render: function() {
				var rawMarkup = marked(this.props.children.toString(), {sanitize: true});
				return (
					<div className="comment">
						<h3 className="commentAuthor">
							{this.props.author}
						</h3>
						<span dangerouslySetInnerHTML={{__html: rawMarkup}} />
					</div>
				);
			}
		});

		var CommentForm = React.createClass({
			handleSubmit: function(e) {
				e.preventDefault();
				var author = React.findDOMNode(this.refs.author).value.trim();
				var text = React.findDOMNode(this.refs.text).value.trim();
				if (!text || !author) {
					return;
				}
				this.props.onCommentSubmit({author: author, text: text});
				React.findDOMNode(this.refs.author).value = '';
				React.findDOMNode(this.refs.text).value = '';
				return;
			},
			render: function() {
				return (
					<form className="commentForm" onSubmit={this.handleSubmit}>
						<input type="text" placeholder="Your name" ref="author" />
						<input type="text" placeholder="Say something..." ref="text" />
						<input type="submit" value="Post" />
					</form>
				);
			}
		})

		var CommentBox = React.createClass({
			loadCommentsFromServer: function() {
				$.ajax({
					url: this.props.url,
					dataType: 'json',
					cache: false,
					success: function(data) {
						this.setState({data: data});
					}.bind(this),
					error: function(xhr, status, err) {
						console.error(this.props.url, status, err.toString());
					}.bind(this)
				});
			},
			handleCommentSubmit: function(comment) {
				var comments = this.state.data;
				var newComments = comments.concat([comment]);
				console.log(newComments);
				this.setState({data: newComments});
				$.ajax({
					url: this.props.url,
					dataType: 'json',
					type: 'POST',
					data: comment,
					success: function(data) {
						this.setState({data: data});
					}.bind(this),
					error: function(xhr, status, err) {
						console.error(this.props.url, status, err.toString());
					}.bind(this)
				});
			},
			getInitialState: function() {
				return {data: []};
			},
			componentDidMount: function() {
				this.loadCommentsFromServer();
				setInterval(this.loadCommentsFromServer, this.props.pollInterval);
			},
			render: function() {
				return (
					<div className="commentBox">
						<h2>Comments</h2>
						<CommentList data={this.state.data} />
						<CommentForm onCommentSubmit={this.handleCommentSubmit} />
					</div>
				);
			}
		});

		React.render(
			<CommentBox url="<?php echo PathToRoot::get(); ?>comments.json" pollInterval={2000} />,
			document.getElementById('comments')
		);
	</script>
<?php } ?>
