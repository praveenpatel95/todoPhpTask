<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    private function __construct()
    {
        // Private to prevent direct instantiation
    }

    public static function connect(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4',
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
