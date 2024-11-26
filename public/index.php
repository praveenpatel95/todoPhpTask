<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$router = require __DIR__ . '/../app/routes/routes.php';

// Dispatch the request to the appropriate route
$router->dispatch();