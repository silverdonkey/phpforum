<?php
namespace Controller;

class PostController {

	public function filterList(\Model\Post $post): \Model\Post {
		if (!empty($_GET['sort'])) {
			$post = $post->sort($_GET['sort']);
		}
		if (!empty($_GET['search'])) {
			$post = $post->search($_GET['search']);
		}
		return $post;
	}

	public function delete(\Model\Post $post): \Model\Post {
		return $post->delete($_POST['id']);
	}

	public function edit(\Model\Post $post): \Model\Post  {
		if (isset($_GET['id'])) {
			return $post->load($_GET['id']);
		}
		else {
			return $post;
		}
	}

	public function submit(\Model\Post $post): \Model\Post  {
		return $post->save($_POST['post']);
	}

}