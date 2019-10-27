<?php
spl_autoload_register(function ($name) {
  $parts = explode('\\', $name);
  $parts[0] = $parts[0] == 'JokeSite' ? 'Model' : $parts[0];
  require './' . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
});
require 'db/config.php';
$pdo = new \Pdo('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$route = $_GET['route'] ?? '';
if ($route == '') {
  $model = new \Model\Posts($pdo);
  $view = new \View\Posts();
} else {
  http_response_code(404);
  echo 'Page not found (Invalid route)';
}
echo $view->output($model);
