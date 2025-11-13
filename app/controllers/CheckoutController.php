<?php
// app/controllers/CheckoutController.php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Shipping.php';
require_once __DIR__ . '/../models/CustomOrder.php';
require_once __DIR__ . '/../models/Product.php';

class CheckoutController
{
    public function form()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Silakan login dulu.";
            header("Location: ?page=login");
            exit;
        }
        $cart = $_SESSION['cart'] ?? [];
        include __DIR__ . '/../views/checkout/form.php';
    }

    public function process()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Silakan login dulu.";
            header("Location: ?page=login");
            exit;
        }

        $user = $_SESSION['user'];
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = "Keranjang kosong.";
            header("Location: ?page=cart");
            exit;
        }

        // hitung total dengan diskon per item
        $total = 0;
        foreach ($cart as $it) {
            $price = $it['price'];
            $disc = isset($it['discount']) ? (float) $it['discount'] : 0;
            $finalPrice = $disc > 0 ? ($price - ($price * $disc / 100)) : $price;
            $total += $finalPrice * $it['qty'];
        }

        $data = [
            'user_id' => $user['id'],
            'total_amount' => $total,
            'payment_method' => $_POST['payment_method'] ?? 'cod',
            'shipping_address' => $_POST['shipping_address'] ?? ''
        ];

        $orderModel = new Order();
        $paymentModel = new Payment();
        $shippingModel = new Shipping();
        $productModel = new Product();
        $customModel = new CustomOrder();

        try {
            $orderId = $orderModel->create($data, $cart);

            // create payment record (pending)
            $paymentModel->create($orderId, $total, $data['payment_method']);

            // create shipping record (status pending)
            $courier = $_POST['courier'] ?? 'jne';
            $shippingModel->create($orderId, $courier, 0);

            // link custom orders (if any)
            foreach ($cart as $it) {
                if (!empty($it['custom_id'])) {
                    $customModel->linkToOrder($it['custom_id'], $orderId);
                }
                // kurangi stok
                if (!empty($it['id'])) {
                    $productModel->reduceStock($it['id'], $it['qty']);
                }
            }

            // kosongkan cart session
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Pesanan berhasil dibuat. ID: $orderId";
            header("Location: ?page=checkout_success&id=" . $orderId);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Gagal membuat pesanan: " . $e->getMessage();
            header("Location: ?page=checkout");
            exit;
        }
    }

    public function success()
    {
        include __DIR__ . '/../views/checkout/success.php';
    }
}
