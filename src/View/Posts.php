<?php

namespace View;

class Posts
{
  public function output(\Model\Posts  $model): string
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
