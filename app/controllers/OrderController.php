<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/CustomOrder.php';

class OrderController
{
    private $orderModel;
    private $customModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->customModel = new CustomOrder();
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

        // kirim custom order per order
        $customOrdersByOrder = [];
        foreach ($orders as $o) {
            $customOrdersByOrder[$o['id']] = $this->customModel->getByOrderId($o['id']);
        }

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

        // Pastikan order milik user ini
        $order = $this->orderModel->find($orderId);
        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Pesanan tidak ditemukan.";
            header("Location: ?page=orders");
            exit;
        }

        $items = $this->orderModel->getItems($orderId);
        $customOrders = $this->customModel->getByOrderId($orderId);

        // 🔑 TAMBAHKAN INI: ambil data shipping
        $shipping = $this->orderModel->getShipping($orderId); // Bisa null jika belum ada

        include __DIR__ . '/../views/user/order_detail.php';
    }
}
