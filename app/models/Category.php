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
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
