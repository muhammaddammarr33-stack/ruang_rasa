<?php
require_once __DIR__ . '/../models/DB.php';

class AdminOrderController
{
    public function updateStatus()
    {
        $db = DB::getInstance();
        $id = $_POST['id'] ?? null;
        $status = $_POST['order_status'] ?? null;

        if (!$id || !$status) {
            header("Location: ?page=admin_orders");
            exit;
        }

        $stmt = $db->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);

        $_SESSION['success'] = "Status pesanan #$id berhasil diubah menjadi '$status'.";
        header("Location: ?page=admin_orders");
    }

    public function showReviews()
    {
        $db = DB::getInstance();
        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            header("Location: ?page=admin_orders");
            exit;
        }

        // Ambil produk dalam order beserta review-nya
        $stmt = $db->prepare("
            SELECT p.id AS product_id, p.name AS product_name, r.rating, r.review, u.name AS reviewer
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN product_reviews r ON r.product_id = p.id
            LEFT JOIN users u ON r.user_id = u.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        $reviews = $stmt->fetchAll();

        include __DIR__ . '/../views/admin/order_reviews.php';
    }
}
