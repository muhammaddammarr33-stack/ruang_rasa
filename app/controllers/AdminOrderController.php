<?php
// app/controllers/AdminOrderController.php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Shipping.php';

class AdminOrderController
{
    private $orderModel;
    private $paymentModel;
    private $shippingModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $this->orderModel = new Order();
        $this->paymentModel = new Payment();
        $this->shippingModel = new Shipping();
    }

    public function index()
    {
        $orders = $this->orderModel->all(); // implement all() in model if needed
        include __DIR__ . '/../views/admin/orders/index.php';
    }

    public function detail()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $order = $this->orderModel->find($id);
        $items = $this->orderModel->getItems($id);
        $payment = $this->orderModel->getPayment($id);
        $shipping = $this->orderModel->getShipping($id);

        include __DIR__ . '/../views/admin/orders/detail.php';
    }


    public function updateStatus()
    {
        $id = $_POST['order_id'];
        $status = $_POST['status'];
        $this->orderModel->updateStatus($id, $status);
        $_SESSION['success'] = "Status pesanan diperbarui.";
        header("Location: ?page=admin_order_detail&id=$id");
    }
}
