<?php
// app/models/Category.php
require_once __DIR__ . '/DB.php';

class Category
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description = null)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
        return $this->db->lastInsertId();
    }

    public function update($id, $name, $description = null)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
