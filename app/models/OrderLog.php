<?php
// app/models/OrderLog.php
require_once __DIR__ . '/DB.php';

class OrderLog
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($orderId, $changedBy = null, $from = null, $to = null, $note = null)
    {
        $stmt = $this->db->prepare("INSERT INTO order_logs (order_id, changed_by, from_status, to_status, note, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$orderId, $changedBy, $from, $to, $note]);
        return $this->db->lastInsertId();
    }

    public function allByOrder($orderId)
    {
        $stmt = $this->db->prepare("SELECT ol.*, u.name AS changed_by_name FROM order_logs ol LEFT JOIN users u ON u.id = ol.changed_by WHERE ol.order_id = ? ORDER BY ol.created_at DESC");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
