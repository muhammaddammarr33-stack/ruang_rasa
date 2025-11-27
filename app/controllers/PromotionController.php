<?php
// app/controllers/PromotionController.php
require_once __DIR__ . '/../models/Promotions.php';
require_once __DIR__ . '/../models/Product.php';

class PromotionController
{
    private $promoModel;
    private $productModel;

    public function __construct()
    {
        $this->promoModel = new Promotions();
        $this->productModel = new Product();

        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    // =======================
    // 👑 BAGIAN ADMIN
    // =======================

    public function adminIndex()
    {
        $this->authAdmin();
        $promos = $this->promoModel->all();
        include __DIR__ . '/../views/admin/promotions/index.php';
    }

    public function adminForm()
    {
        $this->authAdmin();
        $promo = null;
        $linked = [];
        $products = $this->productModel->all();

        if (isset($_GET['id'])) {
            $promo = $this->promoModel->find($_GET['id']);
            $linked = $this->promoModel->getProductsByPromo($_GET['id']);
        }

        include __DIR__ . '/../views/admin/promotions/form.php';
    }

    public function adminSave()
    {
        $this->authAdmin();

        $data = [
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'discount' => $_POST['discount'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'description' => $_POST['description']
        ];

        if (!empty($_POST['id'])) {
            $this->promoModel->update($_POST['id'], $data);
            $promoId = $_POST['id'];
        } else {
            $promoId = $this->promoModel->create($data);
        }

        $selectedProducts = $_POST['products'] ?? [];
        $this->promoModel->syncProducts($promoId, $selectedProducts);

        $_SESSION['success'] = "Promosi berhasil disimpan.";
        header("Location: ?page=admin_promotions");
    }

    public function adminDelete()
    {
        $this->authAdmin();
        $this->promoModel->delete($_GET['id']);
        $_SESSION['success'] = "Promosi berhasil dihapus.";
        header("Location: ?page=admin_promotions");
    }

    private function authAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
    }

    // =======================
    // 👥 BAGIAN USER
    // =======================

    public function listPublic()
    {
        $promos = $this->promoModel->all();
        include __DIR__ . '/../views/landing/promotions.php';
    }
}
