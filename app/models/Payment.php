<?php
// app/models/Payment.php
require_once __DIR__ . '/DB.php';

class Payment
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($orderId, $gateway, $transactionId, $amount, $status)
    {
        $stmt = $this->db->prepare("
        INSERT INTO payments (order_id, payment_gateway, transaction_id, amount, status, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
        $stmt->execute([$orderId, $gateway, $transactionId, $amount, $status]);
    }

    public function getByOrder($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $status, $responseData = null)
    {
        $stmt = $this->db->prepare("
        UPDATE payments 
        SET status = ?, response_data = ?
        WHERE order_id = ?
    ");
        return $stmt->execute([$status, $responseData, $orderId]);
    }


    public function updateTransaction($orderId, $transactionId, $status, $paymentType)
    {
        $stmt = $this->db->prepare("
        UPDATE payments 
        SET transaction_id = ?, 
            status = ?, 
            payment_gateway = ? 
        WHERE order_id = ?
    ");
        return $stmt->execute([$transactionId, $status, $paymentType, $orderId]);
    }

    public function updateAmount($orderId, $newAmount)
    {
        $stmt = $this->db->prepare("UPDATE payments SET amount = ? WHERE order_id = ?");
        return $stmt->execute([$newAmount, $orderId]);
    }

}
