<?php
require_once __DIR__ . '/../models/CustomOrder.php';
require_once __DIR__ . '/../models/Product.php';

class CustomOrderController
{
    private $customModel;

    public function __construct()
    {
        $this->customModel = new CustomOrder();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    public function form()
    {
        if (!isset($_GET['cart_index'])) {
            echo "<p style='color:red'>Item tidak ditemukan di keranjang.</p>";
            return;
        }

        $cartIndex = (int) $_GET['cart_index'];
        $product = $_SESSION['cart'][$cartIndex] ?? null;

        if (!$product) {
            echo "<p style='color:red'>Produk tidak ditemukan di keranjang.</p>";
            return;
        }

        include __DIR__ . '/../views/custom_orders/form.php';
    }


    public function create()
    {
        $userId = $_SESSION['user']['id'];
        $cartIndex = (int) $_POST['cart_index'];
        $product = $_SESSION['cart'][$cartIndex];

        $data = [
            'custom_text' => $_POST['custom_text'],
            'font_style' => $_POST['font_style'],
            'text_color' => $_POST['text_color'],
            'packaging_type' => $_POST['packaging_type'],
            'ribbon_color' => $_POST['ribbon_color'],
            'special_instructions' => $_POST['special_instructions']
        ];

        $customId = $this->customModel->create($userId, $product['id'], $data);
        $this->customModel->updateStatus($customId, 'added_to_cart');

        // simpan ID custom order ke item cart
        $_SESSION['cart'][$cartIndex]['custom_id'] = $customId;
        $_SESSION['cart'][$cartIndex]['custom_text'] = $data['custom_text'];

        $_SESSION['success'] = "Personalisasi berhasil disimpan!";
        header("Location: ?page=cart");
        exit;
    }


    public function list()
    {
        $userId = $_SESSION['user']['id'];
        $orders = $this->customModel->allByUser($userId);
        include __DIR__ . '/../views/custom_orders/list.php';
    }

    public function detail()
    {
        $id = $_GET['id'];
        $order = $this->customModel->find($id);
        include __DIR__ . '/../views/custom_orders/detail.php';
    }
}
