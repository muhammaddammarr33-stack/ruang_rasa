<?php
require_once __DIR__ . '/DB.php';

class Consultation
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($userId, $recipient, $occasion, $age_range, $interests, $budget_range)
    {
        $sql = "INSERT INTO consultations (user_id, recipient, occasion, age_range, interests, budget_range, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'submitted', NOW())";
        return $this->db->prepare($sql)->execute([$userId, $recipient, $occasion, $age_range, $interests, $budget_range]);
    }

    public function getByUser($id)
    {
        $q = $this->db->prepare("SELECT * FROM consultations WHERE user_id=? ORDER BY created_at DESC");
        $q->execute([$id]);
        return $q->fetchAll();
    }

    public function getAll()
    {
        return $this->db->query("
            SELECT c.*, u.name as user_name
            FROM consultations c
            JOIN users u ON u.id = c.user_id
            ORDER BY c.created_at DESC
        ")->fetchAll();
    }

    public function find($id)
    {
        $q = $this->db->prepare("
            SELECT c.*, u.name as user_name
            FROM consultations c
            JOIN users u ON u.id=c.user_id
            WHERE c.id=?
        ");
        $q->execute([$id]);
        return $q->fetch();
    }

    public function updateStatus($id, $status)
    {
        return $this->db->prepare("UPDATE consultations SET status=? WHERE id=?")
            ->execute([$status, $id]);
    }
}
