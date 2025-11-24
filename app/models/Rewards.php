<?php
// app/models/Rewards.php
require_once __DIR__ . '/DB.php';

class Rewards
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM rewards ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM rewards WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO rewards (name, points_required, description, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$data['name'], $data['points_required'], $data['description']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE rewards SET name = ?, points_required = ?, description = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['points_required'], $data['description'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM rewards WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getUserRedemptionHistory($userId)
    {
        $sql = "
        SELECT rr.*, r.name, r.points_required
        FROM reward_redemptions rr
        JOIN rewards r ON r.id = rr.reward_id
        WHERE rr.user_id = ?
        ORDER BY rr.redeemed_at DESC
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRedemptionHistory()
    {
        $sql = "
        SELECT rr.*, 
               r.name, r.points_required,
               u.name AS user_name
        FROM reward_redemptions rr
        JOIN rewards r ON r.id = rr.reward_id
        JOIN users u ON u.id = rr.user_id
        ORDER BY rr.redeemed_at DESC
    ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

}
