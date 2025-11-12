<?php
// app/models/Order.php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/Payment.php';
class Order
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    /**
     * $data expected keys:
     * - user_id (int)
     * - total_amount (float)
     * - payment_method (string) -> one of ('cod','transfer','ewallet','gateway')
     * - shipping_address (string)
     *
     * $cart: array of items each with keys: id, name, price, qty
     *
     * Returns inserted order id on success.
     */
    public function create(array $data, array $cart)
    {
        $this->db->beginTransaction();
        try {
            // 1) Insert ke tabel orders (sesuai schema yang kamu kirim)
            $stmt = $this->db->prepare("
                INSERT INTO orders
                  (user_id, total_amount, payment_method, payment_status, order_status, shipping_address, tracking_number, created_at)
                VALUES
                  (?, ?, ?, 'pending', 'waiting', ?, NULL, ?)
            ");
            $now = date('Y-m-d H:i:s');
            $stmt->execute([
                $data['user_id'],
                $data['total_amount'],
                $data['payment_method'],
                $data['shipping_address'],
                $now
            ]);
            $orderId = $this->db->lastInsertId();

            // 2️⃣ Insert order_items (dengan subtotal)
            $stmtItem = $this->db->prepare("
    INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
    VALUES (?, ?, ?, ?, ?)
");
            foreach ($cart as $item) {
                $subtotal = $item['price'] * $item['qty'];
                $stmtItem->execute([
                    $orderId,
                    $item['id'],
                    $item['qty'],
                    $item['price'],
                    $subtotal
                ]);
            }

            /* 🟢 === Tambahkan di sini (tepat setelah loop order_items) === */

            // Panggil model Payment
            $paymentModel = new Payment();

            // Simpan data pembayaran
            $paymentModel->create(
                $orderId,
                $data['payment_method'],
                $data['total_amount'],
                'success',
                ['note' => 'Simulasi pembayaran otomatis']
            );

            // Update status order setelah pembayaran berhasil
            $this->db->prepare("
                UPDATE orders
                SET payment_status = 'paid',
                    order_status = 'processing'
                WHERE id = ?
            ")->execute([$orderId]);

            /* 🟢 === Setelah ini lanjut ke commit seperti biasa === */

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order::create error: " . $e->getMessage());
            throw $e;
        }
    }
}
