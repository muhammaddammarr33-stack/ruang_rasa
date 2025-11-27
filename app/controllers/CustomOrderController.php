<?php
// app/controllers/CustomOrderController.php
require_once __DIR__ . '/../models/CustomOrder.php';
require_once __DIR__ . '/../models/Product.php';

class CustomOrderController
{
    private $customModel;
    private $productModel;

    public function __construct()
    {
        $this->customModel = new CustomOrder();
        $this->productModel = new Product();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    // show form to personalize an item in cart
    public function form()
    {
        if (!isset($_GET['cart_index'])) {
            echo "<p style='color:red'>Item tidak ditemukan di keranjang.</p>";
            return;
        }

        $cartIndex = (int) $_GET['cart_index'];
        $productItem = $_SESSION['cart'][$cartIndex] ?? null;

        if (!$productItem) {
            echo "<p style='color:red'>Produk tidak ditemukan di keranjang.</p>";
            return;
        }

        // fetch product for display (optional)
        $product = $this->productModel->find($productItem['id']);
        include __DIR__ . '/../views/custom_orders/form.php';
    }

    // handle create custom order and link to cart session
    public function create()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Silakan login untuk membuat personalisasi.";
            header("Location: ?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cartIndex = isset($_POST['cart_index']) ? (int) $_POST['cart_index'] : null;
        if ($cartIndex === null || !isset($_SESSION['cart'][$cartIndex])) {
            $_SESSION['error'] = "Item keranjang tidak ditemukan.";
            header("Location: ?page=cart");
            exit;
        }

        $productItem = $_SESSION['cart'][$cartIndex];
        $productId = $productItem['id'];

        $data = [
            'custom_text' => trim($_POST['custom_text'] ?? ''),
            'font_style' => $_POST['font_style'] ?? 'normal',
            'text_color' => $_POST['text_color'] ?? '#000000',
            'packaging_type' => $_POST['packaging_type'] ?? '',
            'ribbon_color' => $_POST['ribbon_color'] ?? '',
            'special_instructions' => trim($_POST['special_instructions'] ?? '')
        ];

        // create custom order record
        $customId = $this->customModel->create($userId, $productId, $data);
        $this->customModel->updateStatus($customId, 'added_to_cart');

        // store custom info into session cart item
        $_SESSION['cart'][$cartIndex]['custom_id'] = $customId;
        $_SESSION['cart'][$cartIndex]['custom_text'] = $data['custom_text'];
        $_SESSION['cart'][$cartIndex]['custom_font'] = $data['font_style'];
        $_SESSION['cart'][$cartIndex]['custom_color'] = $data['text_color'];
        $_SESSION['cart'][$cartIndex]['custom_packaging'] = $data['packaging_type'];
        $_SESSION['cart'][$cartIndex]['custom_ribbon'] = $data['ribbon_color'];
        $_SESSION['cart'][$cartIndex]['custom_note'] = $data['special_instructions'];

        $_SESSION['success'] = "Personalisasi berhasil disimpan.";
        header("Location: ?page=cart");
        exit;
    }

    public function list()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        $userId = $_SESSION['user']['id'];
        $orders = $this->customModel->allByUser($userId);
        include __DIR__ . '/../views/custom_orders/list.php';
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID personalisasi tidak ditemukan.";
            return;
        }
        $order = $this->customModel->find($id);
        include __DIR__ . '/../views/custom_orders/detail.php';
    }
}
