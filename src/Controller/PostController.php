<?php
namespace Controller;

class PostController {

	public function filterList(\Model\Posts $postList): \Model\Posts  {
		if (!empty($_GET['sort'])) {
			$postList = $postList->sort($_GET['sort']);
		}
		if (!empty($_GET['search'])) {
			$postList = $postList->search($_GET['search']);
		}
		return $postList;
	}

	public function delete(\Model\Posts  $postList): \Model\Posts  {
		return $postList->delete($_POST['id']);
	}

	public function edit(\Model\PostForm  $postForm): \Model\PostForm  {
		if (isset($_GET['id'])) {
			return $postForm->load($_GET['id']);
		}
		else {
			return $postForm;
		}
	}

	public function submit(\Model\PostForm  $postForm): \Model\PostForm  {
		return $postForm->save($_POST['post']);
	}

}