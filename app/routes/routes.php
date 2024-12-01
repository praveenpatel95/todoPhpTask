<?php

use Core\Router;
use Core\AuthMiddleware;
use Controllers\TaskController;
use Controllers\AuthController;

$router = new Router();

// Public routes (no authentication required)
$router->register('POST', '/register', [AuthController::class, 'register']);
$router->register('POST', '/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
$router->register('GET', '/tasks', [TaskController::class, 'index'], [AuthMiddleware::class]);
$router->register('POST', '/tasks', [TaskController::class, 'store'], [AuthMiddleware::class]);
$router->register('GET', '/tasks/(\d+)', [TaskController::class, 'show'], [AuthMiddleware::class]);
$router->register('POST', '/tasks/(\d+)', [TaskController::class, 'update'], [AuthMiddleware::class]);
$router->register('DELETE', '/tasks/(\d+)', [TaskController::class, 'destroy'], [AuthMiddleware::class]);

return $router;