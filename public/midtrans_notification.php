<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/models/Payment.php';
require_once __DIR__ . '/../app/models/Order.php';

$config = require __DIR__ . '/../app/config.php';

\Midtrans\Config::$serverKey = $config['midtrans']['server_key'];
\Midtrans\Config::$isProduction = $config['midtrans']['is_production'];

$notif = new \Midtrans\Notification();

$orderIdRaw = $notif->order_id; // contoh: RR15-1700000000
$transaction = $notif->transaction_status;
$fraud = $notif->fraud_status;
$transactionId = $notif->transaction_id;

if (preg_match('/RR(\d+)-/', $orderIdRaw, $match)) {
    $orderId = (int) $match[1];
} else {
    die("invalid order id");
}

$paymentModel = new Payment();
$orderModel = new Order();

switch ($transaction) {
    case 'settlement':
        $paymentModel->updateStatus($orderId, 'paid');
        $orderModel->updateStatus($orderId, 'processing');
        break;

    case 'pending':
        $paymentModel->updateStatus($orderId, 'pending');
        $orderModel->updateStatus($orderId, 'waiting');
        break;

    case 'deny':
    case 'expire':
    case 'cancel':
        $paymentModel->updateStatus($orderId, 'failed');
        $orderModel->updateStatus($orderId, 'cancelled');
        break;
}

http_response_code(200);
echo "OK";
