<?php
require_once '../config/database.php';
require_once '../controllers/TasksController.php';

$url = $_GET['url'] ?? 'tasks';
$url = explode('/', $url);

$controllerPart = strtolower($url[0]);
$controllerName = ucfirst($url[0]) . 'Controller';
$action = $url[1] ?? 'index';


// Include controller file dynamically
$controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
} else {
    http_response_code(404);
    die("Controller file not found: " . $controllerFile);
}


if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Method not found";
    }
} else {
    http_response_code(404);
    echo "Controller not found";
}
?>