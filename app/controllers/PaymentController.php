<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Payment.php';

// load config dengan cek keberadaan file
$configPath = __DIR__ . '/../config_midtrans.php';
if (!file_exists($configPath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Midtrans config missing: ' . $configPath]);
    exit;
}

$config = require $configPath;

// validasi keys
if (empty($config['server_key']) || empty($config['client_key'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Midtrans keys not set. Please set server_key and client_key in app/config_midtrans.php']);
    exit;
}

\Midtrans\Config::$serverKey = $config['server_key'];
\Midtrans\Config::$isProduction = !empty($config['is_production']);

class PaymentController
{
    public function getSnapToken()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $orderId = $_POST['order_id'] ?? 0;
        $orderModel = new Order();
        $order = $orderModel->find($orderId);

        if (!$order) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Order not found']);
            exit;
        }

        $orderItems = $orderModel->getItems($orderId);
        $items = [];

        foreach ($orderItems as $it) {
            $items[] = [
                'id' => $it['product_id'],
                'price' => (float) $it['price'],
                'quantity' => (int) $it['quantity'],
                'name' => $it['product_name']
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'RR' . $orderId . '-' . time(),
                'gross_amount' => (float) $order['total_amount']
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $_SESSION['user']['name'] ?? 'Customer',
                'email' => $_SESSION['user']['email'] ?? ''
            ]
        ];

        try {
            $token = \Midtrans\Snap::getSnapToken($params);
            header('Content-Type: application/json');
            echo json_encode(['token' => $token]);
        } catch (Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Midtrans error: ' . $e->getMessage()]);
        }
    }
    // verify function (if exists) should similarly check config

    public function verify()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $orderId = $_GET['id'] ?? 0;
        if (!$orderId) {
            echo "Invalid order ID";
            exit;
        }

        // load config
        $config = require __DIR__ . '/../config_midtrans.php';
        \Midtrans\Config::$serverKey = $config['server_key'];
        \Midtrans\Config::$isProduction = $config['is_production'];

        $paymentModel = new Payment();
        $orderModel = new Order();

        // Ambil data payment berdasarkan order_id
        $payment = $paymentModel->getByOrder($orderId);
        if (!$payment) {
            echo "Payment record not found";
            exit;
        }

        // Ambil status transaksi dari Midtrans
        $result = \Midtrans\Transaction::status($payment['transaction_id']);

        // response_data → simpan JSON response lengkap dari Midtrans
        $responseJson = json_encode($result);

        // Ekstrak status dari Midtrans
        $transactionStatus = $result->transaction_status;  // settlement/pending/cancel/etc.

        if ($transactionStatus === 'settlement') {
            // update payments table
            $paymentModel->updateStatus($orderId, 'success', $responseJson);

            // update orders table
            $orderModel->updatePaymentStatus($orderId, 'paid');
            $orderModel->updateOrderStatus($orderId, 'processing');

        } elseif ($transactionStatus === 'pending') {

            $paymentModel->updateStatus($orderId, 'pending', $responseJson);
            $orderModel->updatePaymentStatus($orderId, 'pending');
            $orderModel->updateOrderStatus($orderId, 'waiting');

        } else {

            $paymentModel->updateStatus($orderId, 'failed', $responseJson);
            $orderModel->updatePaymentStatus($orderId, 'failed');
            $orderModel->updateOrderStatus($orderId, 'cancelled');
        }

        header("Location: ?page=order_detail&id=$orderId");
        exit;
    }



    public function saveTransaction()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $orderId = $data['order_id'];
        $transactionId = $data['transaction_id'];
        $status = $data['status'];
        $payment_type = $data['payment_type'];

        $paymentModel = new Payment();

        // update payment record
        $paymentModel->updateTransaction($orderId, $transactionId, $status, $payment_type);

        echo json_encode(['success' => true]);
        exit;
    }

}
