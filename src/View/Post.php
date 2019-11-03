<?php
namespace View;

class Post {

	public function show(\Model\Post $model): string {
		$errors = $model->getErrors();
		if ($model->isSubmitted() && empty($errors)) {
			//On success, redirect to list page
			header('location: index.php');
			die;
		}
		$post = $model->getPost();
		$output = '';
		if (!empty($errors)) {
			$output .= '<p>The record could not be saved:</p>';
			$output .= '<ul>';
			foreach ($errors as $error) {
				$output .= '<li>' . $error . '</li>';
			}
			$output .= '</ul>';
		}
		$output .= '<form action="" method="post">
				<input type="hidden" value="' . ($post['id'] ?? ''). '" name="post[id]" />
				Subject: <input name="post[subject] type="text" value="' . ($post['subject'] ?? ''). '" /> <br />
				Content: <textarea name="post[content]">' . ($post['content'] ?? '') . '</textarea>
				<input type="hidden" value="' . ($post['user_id'] ?? '1'). '" name="post[user_id]" />
				<input type="submit" value="submit" />
			</form>';
		return $output;
	}

  public function index(\Model\Post $model): string
  {
    $output = '
		<p><a href="index.php?route=edit">Add new post</a></p>
		<form action="" method="get">
				<input type="hidden" value="filterList" name="route" />
				<input type="hidden" value="' . $model->getSort() . '" name="sort" />
				<input type="text"  placeholder="Enter search text" name="search" />
				<input type="submit" value="submit" />
			</form>
			<p>Sort: <a href="index.php?route=filterList&amp;sort=newest">Newest first</a> | <a href="index.php?route=filterList&amp;sort=oldest">Oldest first</a>
			<ul>
			';
    foreach ($model->getPosts() as $post) {
      $output .= '<li>' . $post['subject'] . ' (created by ' . $post['first_name'] . ' ' . $post['last_name'] . ')';
      $output .= ' <a href="index.php?route=edit&amp;id=' . $post['id'] . '">Edit</a>';
      $output .= '<form action="index.php?route=delete" method="POST">
						<input type="hidden" name="id" value="' . $post['id'] . '" />
						<input type="submit" value="Delete" />
						</form>';
      $output .=   '</li>';
    }
    $output .= '</ul>';
    return $output;
  }
}