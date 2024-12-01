<?php

namespace Models;

use Core\Database;
use PDO;
class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findByEmail(string $email): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchObject() ?: null;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $data['name'], 'email' => $data['email'], 'password' => $data['password']]);
    }
}
