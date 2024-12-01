<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Handle CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Handle preflight (OPTIONS) request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond to preflight request
    http_response_code(200); // HTTP OK status
    exit;
}

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$router = require __DIR__ . '/../app/routes/routes.php';

// Dispatch the request to the appropriate route
$router->dispatch();
