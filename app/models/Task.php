<?php

namespace Models;

use Core\Database;
use PDO;
class Task
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM tasks ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO tasks (title, description) VALUES (:title, :description)");
        return $stmt->execute(['title' => $data['title'], 'description' => $data['description']]);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function find(int $id): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE tasks SET title = :title, description = :description WHERE id = :id");
        return $stmt->execute(['id' => $id, 'title' => $data['title'], 'description' => $data['description']]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
