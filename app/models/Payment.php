<?php
require_once __DIR__ . '/DB.php';

class Payment
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($orderId, $amount, $method)
    {
        $stmt = $this->db->prepare("
            INSERT INTO payments (order_id, payment_gateway, transaction_id, amount, status, created_at)
            VALUES (?, ?, ?, ?, 'pending', NOW())
        ");
        $txid = uniqid("TX_");
        $stmt->execute([$orderId, $method, $txid, $amount]);
    }

    public function markPaid($orderId)
    {
        $stmt = $this->db->prepare("UPDATE payments SET status='success' WHERE order_id=?");
        $stmt->execute([$orderId]);
    }
}
