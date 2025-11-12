<?php
// app/controllers/CartController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class CartController
{
    private $productModel;
    private $orderModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['cart']))
            $_SESSION['cart'] = [];
    }

    public function add()
    {
        $id = $_POST['id'] ?? null;
        if (!$id)
            return header('Location: ?page=landing');
        if (!isset($_SESSION['user']))
            return header('Location: ?page=login');

        $product = $this->productModel->find($id);
        if (!$product)
            return;

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => 1
            ];
        }

        header('Location: ?page=cart');
    }

    public function index()
    {
        $cart = $_SESSION['cart'];
        include __DIR__ . '/../views/cart/index.php';
    }

    public function remove()
    {
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);
        header('Location: ?page=cart');
    }

    public function checkoutForm()
    {
        if (!isset($_SESSION['user']))
            return header('Location: ?page=login');
        $cart = $_SESSION['cart'];
        include __DIR__ . '/../views/cart/checkout.php';
    }

    public function checkout()
    {
        $user = $_SESSION['user'];
        $cart = $_SESSION['cart'];
        if (empty($cart)) {
            $_SESSION['error'] = "Keranjang kosong.";
            header('Location: ?page=cart');
            return;
        }

        // pastikan ini ada di CartController::checkout()
        $total = 0;
        foreach ($cart as $it) {
            $total += ($it['price'] * $it['qty']);
        }

        $data = [
            'user_id' => $user['id'],
            'total_amount' => $total,
            'payment_method' => $_POST['payment_method'],          // 'cod'|'transfer'|'ewallet'|'gateway'
            'shipping_address' => $_POST['shipping_address'] ?? '' // gunakan nama shipping_address
        ];

        $orderId = $this->orderModel->create($data, $cart);

        // 🔹 Hubungkan custom order dengan order_id baru
        require_once __DIR__ . '/../models/CustomOrder.php';
        $customModel = new CustomOrder();

        foreach ($_SESSION['cart'] as $item) {
            if (isset($item['custom_id'])) {
                $customModel->linkToOrder($item['custom_id'], $orderId);
            }
        }

        unset($_SESSION['cart']);
        $_SESSION['success'] = "Pesanan berhasil dibuat! ID Pesanan: $orderId";
        header('Location: ?page=cart');
    }
}
