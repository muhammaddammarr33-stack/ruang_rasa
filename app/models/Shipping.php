<?php
require_once __DIR__ . '/DB.php';

class Shipping
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($orderId, $courier, $cost)
    {
        $stmt = $this->db->prepare("
            INSERT INTO shippings (order_id, courier, shipping_cost, status, updated_at)
            VALUES (?, ?, ?, 'pending', NOW())
        ");
        $stmt->execute([$orderId, $courier, $cost]);
    }

    public function updateStatus($orderId, $status, $tracking = null)
    {
        $stmt = $this->db->prepare("
            UPDATE shippings SET status=?, tracking_number=?, updated_at=NOW() WHERE order_id=?
        ");
        $stmt->execute([$status, $tracking, $orderId]);
    }
}
