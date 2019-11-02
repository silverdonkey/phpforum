<?php
namespace View;

class PostForm {

	public function output(\Model\PostForm $model): string {
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

}