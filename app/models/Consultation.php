<?php
require_once __DIR__ . '/DB.php';

class Consultation
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($userId, $topic, $budget, $preference)
    {
        $stmt = $this->db->prepare("
            INSERT INTO consultations (user_id, topic, budget, preference, status, created_at)
            VALUES (?, ?, ?, ?, 'submitted', NOW())
        ");
        return $stmt->execute([$userId, $topic, $budget, $preference]);
    }

    public function getByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM consultations WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM consultations ORDER BY created_at DESC")->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE consultations SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
