<?php
require_once __DIR__ . '/DB.php';

class Order
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($data, $cart)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, total_amount, payment_method, payment_status, order_status, shipping_address, created_at)
                VALUES (?, ?, ?, 'pending', 'waiting', ?, NOW())
            ");
            $stmt->execute([
                $data['user_id'],
                $data['total_amount'],
                $data['payment_method'],
                $data['shipping_address']
            ]);
            $orderId = $this->db->lastInsertId();

            // insert order_items
            $stmtItem = $this->db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
                VALUES (?, ?, ?, ?, ?)
            ");
            foreach ($cart as $item) {
                $finalPrice = isset($item['discount'])
                    ? $item['price'] - ($item['price'] * $item['discount'] / 100)
                    : $item['price'];

                $subtotal = $finalPrice * $item['qty'];
                $stmtItem->execute([$orderId, $item['id'], $item['qty'], $finalPrice, $subtotal]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAllByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetail($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT o.*, p.status AS payment_status_real, s.status AS shipping_status
            FROM orders o
            LEFT JOIN payments p ON o.id = p.order_id
            LEFT JOIN shippings s ON o.id = s.order_id
            WHERE o.id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($orderId)
    {
        $sql = "
        SELECT 
            oi.*, 
            p.name AS product_name, 
            p.price AS original_price,
            pi.image_path AS image
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id = p.id
        LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
        WHERE oi.order_id = ?
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function all()
    {
        $sql = "SELECT o.*, u.name AS user_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT o.*, u.name AS user_name, u.email AS user_email
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPayment($orderId)
    {
        $sql = "SELECT * FROM payments WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getShipping($orderId)
    {
        $sql = "SELECT * FROM shippings WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInvoiceData($orderId)
    {
        $stmt = $this->db->prepare("
        SELECT o.*, u.name AS customer_name, u.email AS customer_email
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        WHERE o.id = ?
    ");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $itemStmt = $this->db->prepare("
        SELECT oi.*, p.name AS product_name
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
        $itemStmt->execute([$orderId]);
        $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'order' => $order,
            'items' => $items
        ];
    }

    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("
        UPDATE orders 
        SET order_status = ?, updated_at = NOW()
        WHERE id = ?
    ");
        return $stmt->execute([$status, $orderId]);
    }

    public function updatePaymentStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("
        UPDATE orders 
        SET payment_status = ?
        WHERE id = ?
    ");
        return $stmt->execute([$status, $orderId]);
    }

}
