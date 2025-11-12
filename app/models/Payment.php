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

    /**
     * Simpan pembayaran baru (dipanggil dari Order.php)
     */
    public function create($orderId, $paymentMethod, $amount, $status = 'success', $response = [])
    {
        $transactionId = 'TRX' . time() . rand(1000, 9999);
        $responseData = [
            'gateway_response' => $response,
            'created_by' => 'system',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        $stmt = $this->db->prepare("
            INSERT INTO payments
                (order_id, payment_gateway, transaction_id, amount, status, response_data, created_at)
            VALUES
                (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $orderId,
            $paymentMethod,
            $transactionId,
            $amount,
            $status,
            json_encode($responseData),
            date('Y-m-d H:i:s')
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Ambil data pembayaran berdasarkan order_id
     */
    public function getByOrder($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetch();
    }

    /**
     * Ambil semua pembayaran (untuk admin dashboard)
     */
    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM payments ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}
