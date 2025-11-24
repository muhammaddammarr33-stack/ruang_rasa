<?php
require_once __DIR__ . '/../models/Product.php';

class CartController
{
    private $productModel;
    public function __construct()
    {
        $this->productModel = new Product();
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
        $product = $this->productModel->find($id);
        $priceData = $this->productModel->getFinalPrice($id);
        $finalPrice = $priceData['final_price'];
        $discountPercent = $priceData['discount_percent'];

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $finalPrice,
                'discount_percent' => $discountPercent,
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

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['cart']) || empty($_POST['qty'])) {
            $_SESSION['error'] = "Tidak ada data untuk diperbarui.";
            header("Location: ?page=cart");
            exit;
        }

        foreach ($_POST['qty'] as $index => $qty) {
            $qty = max(1, (int) $qty);
            if (isset($_SESSION['cart'][$index])) {
                $_SESSION['cart'][$index]['qty'] = $qty;
            }
        }

        $_SESSION['success'] = "Jumlah item berhasil diperbarui.";
        header("Location: ?page=cart");
        exit;
    }

    public function addToCartAjax()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user'])) {
            return json_encode(['success' => false, 'error' => 'Harus login']);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if (!$id) {
            return json_encode(['success' => false, 'error' => 'ID produk tidak valid']);
        }

        $product = $this->productModel->find($id);
        if (!$product) {
            return json_encode(['success' => false, 'error' => 'Produk tidak ditemukan']);
        }

        $priceData = $this->productModel->getFinalPrice($id);
        $finalPrice = $priceData['final_price'];
        $discountPercent = $priceData['discount_percent'];

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $finalPrice,
                'discount_percent' => $discountPercent,
                'qty' => 1
            ];
        }

        return json_encode([
            'success' => true,
            'message' => htmlspecialchars($product['name']) . ' ditambahkan ke keranjang!'
        ]);
    }
}
