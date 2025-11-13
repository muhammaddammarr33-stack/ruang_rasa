<?php
require_once __DIR__ . '/../models/Order.php';


class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    // 🔹 Menampilkan riwayat pesanan user
    public function history()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getByUser($userId);
        include __DIR__ . '/../views/user/orders.php';
    }

    // 🔹 Menampilkan detail pesanan user
    public function detail()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        $orderId = $_GET['id'] ?? 0;
        $order = $this->orderModel->find($orderId);
        $items = $this->orderModel->getItems($orderId);

        include __DIR__ . '/../views/user/order_detail.php';
    }
}
