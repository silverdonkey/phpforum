<?php

spl_autoload_register(function ($name) {
  $parts = explode('\\', $name);
  //$parts[0] = $parts[0] == 'db' ? 'Model' : $parts[0];
  require './' . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
});

//$dbHandle = \Database::getInstance()->getDBConnection();
require_once('db/config.php');

$pdo = new \Pdo('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$route = $_GET['route'] ?? '';
if ($route == '') {
  $model = new \Model\Post($pdo);
  $view = new \View\Post();
  echo $view->index($model);
} else if ($route == 'edit') {
	$model = new \Model\Post($pdo);
	$controller = new \Controller\PostController();
	$model = $controller->edit($model);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$model = $controller->submit($model);
	}
	$view = new \View\Post();
	echo $view->show($model);
} else if ($route == 'delete') {
	$model = new \Model\Post($pdo);
	$controller = new \Controller\PostController();
	$model = $controller->delete($model);
	$view = new \View\Post();
	echo $view->index($model);
} else if ($route == 'filterList') {
	$model = new \Model\Post($pdo);
	$view = new \View\Post();
	$controller = new \Controller\PostController();
	$model = $controller->filterList($model);
	echo $view->index($model);
} else {
  http_response_code(404);
  echo 'Page not found (Invalid route)';
}
