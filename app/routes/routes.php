<?php

use Core\Router;
use Controllers\TaskController;

$router = new Router();

$router->register('GET', '/tasks', [TaskController::class, 'index']);
$router->register('POST', '/tasks', [TaskController::class, 'store']);
$router->register('GET', '/tasks/(\d+)', [TaskController::class, 'show']);
$router->register('POST', '/tasks/(\d+)', [TaskController::class, 'update']);
$router->register('DELETE', '/tasks/(\d+)', [TaskController::class, 'destroy']);

return $router;
