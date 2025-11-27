<?php
// app/controllers/AdminOrderController.php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderLog.php';
require_once __DIR__ . '/../models/Shipping.php';

class AdminOrderController
{
    private $orderModel;
    private $logModel;
    private $shippingModel; // <-- tambahkan ini

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $this->orderModel = new Order();
        $this->logModel = new OrderLog();
        $this->shippingModel = new Shipping(); // <-- inisialisasi
    }

    // List orders with filters
    public function index()
    {
        $filters = [
            'q' => $_GET['q'] ?? null,
            'status' => $_GET['status'] ?? null,
            'payment_status' => $_GET['payment_status'] ?? null,
            'date_from' => $_GET['date_from'] ?? null,
            'date_to' => $_GET['date_to'] ?? null
        ];

        $page = max(1, (int) ($_GET['p'] ?? 1));
        $res = $this->orderModel->filterList($filters, $page, 20);

        $orders = $res['data'];
        $total = $res['total'];
        $perPage = $res['per_page'];

        include __DIR__ . '/../views/admin/orders/index.php';
    }

    // Detail view
    public function detail()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if (!$id) {
            echo "Order ID missing";
            exit;
        }

        $order = $this->orderModel->find($id);
        if (!$order) {
            echo "Order not found";
            exit;
        }

        $items = $this->orderModel->getItems($id);
        $payment = $this->orderModel->getPayment($id);
        $logs = $this->logModel->allByOrder($id);
        $shipping = $this->shippingModel->getByOrderId($id); // ✅ gunakan Shipping model

        include __DIR__ . '/../views/admin/orders/detail.php';
    }

    // Update status
    public function updateStatus()
    {
        $orderId = (int) ($_POST['order_id'] ?? 0);
        $field = $_POST['field'] ?? null;
        $new = $_POST['new_status'] ?? null;
        $note = $_POST['note'] ?? null;

        if (!$orderId || !$field || !$new) {
            $_SESSION['error'] = "Invalid input";
            header("Location: ?page=admin_order_detail&id=$orderId");
            exit;
        }

        $order = $this->orderModel->find($orderId);
        $changedBy = $_SESSION['user']['id'] ?? null;

        if ($field === 'order_status') {
            $from = $order['order_status'];
            $this->orderModel->updateOrderStatus($orderId, $new);
        } else {
            $from = $order['payment_status'];
            $this->orderModel->updatePaymentStatus($orderId, $new);
        }

        $this->logModel->create($orderId, $changedBy, $from, $new, $note);

        $_SESSION['success'] = "Status diperbarui.";
        header("Location: ?page=admin_order_detail&id=" . $orderId);
        exit;
    }

    public function cancel()
    {
        $orderId = (int) ($_POST['order_id'] ?? 0);
        $reason = $_POST['reason'] ?? null;

        $order = $this->orderModel->find($orderId);

        if (!$order) {
            $_SESSION['error'] = "Order tidak ditemukan.";
            header("Location: ?page=admin_orders");
            exit;
        }

        // rules → tidak bisa cancel jika sudah shipped atau completed
        if (in_array($order['order_status'], ['shipped', 'completed'])) {
            $_SESSION['error'] = "Order tidak bisa dibatalkan.";
            header("Location: ?page=admin_order_detail&id=$orderId");
            exit;
        }

        $this->orderModel->cancel($orderId, $reason);

        // log
        $this->logModel->create($orderId, $_SESSION['user']['id'], $order['order_status'], 'cancelled', $reason);

        $_SESSION['success'] = "Order berhasil dibatalkan.";
        header("Location: ?page=admin_order_detail&id=$orderId");
        exit;
    }

    public function refund()
    {
        $orderId = (int) ($_POST['order_id'] ?? 0);
        $amount = (int) ($_POST['amount'] ?? 0);
        $note = $_POST['note'] ?? null;

        $order = $this->orderModel->find($orderId);

        if (!$order) {
            $_SESSION['error'] = "Order tidak ditemukan.";
            header("Location: ?page=admin_orders");
            exit;
        }

        // refund tidak boleh lebih dari total
        if ($amount > $order['total_amount']) {
            $_SESSION['error'] = "Jumlah refund terlalu besar.";
            header("Location: ?page=admin_order_detail&id=$orderId");
            exit;
        }

        $this->orderModel->refund($orderId, $amount, $note);

        // log
        $this->logModel->create(
            $orderId,
            $_SESSION['user']['id'],
            $order['payment_status'],
            'refunded',
            "Refund Rp " . number_format($amount, 0, ',', '.') . ". $note"
        );

        $_SESSION['success'] = "Refund berhasil diproses.";
        header("Location: ?page=admin_order_detail&id=$orderId");
        exit;
    }


    // Export CSV
    public function export()
    {
        $filters = [
            'q' => $_GET['q'] ?? null,
            'status' => $_GET['status'] ?? null,
            'payment_status' => $_GET['payment_status'] ?? null,
            'date_from' => $_GET['date_from'] ?? null,
            'date_to' => $_GET['date_to'] ?? null
        ];

        $res = $this->orderModel->filterList($filters, 1, 999999);
        $orders = $res['data'];

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=orders_export.csv");

        $f = fopen("php://output", "w");
        fputcsv($f, ["ID", "Customer", "Total", "Order Status", "Payment Status", "Tanggal"]);

        foreach ($orders as $o) {
            fputcsv($f, [
                $o['id'],
                $o['user_name'],
                $o['total_amount'],
                $o['order_status'],
                $o['payment_status'],
                $o['created_at']
            ]);
        }
        fclose($f);
        exit;
    }
}
