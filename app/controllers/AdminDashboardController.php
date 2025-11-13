<?php
// app/controllers/AdminDashboardController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Orders.php';
require_once __DIR__ . '/../models/Promotions.php';
require_once __DIR__ . '/../models/Consultation.php';
require_once __DIR__ . '/../models/CustomOrder.php';
require_once __DIR__ . '/../models/Memberships.php';

class AdminDashboardController
{
    private $productModel;
    private $orderModel;
    private $promoModel;
    private $consultModel;
    private $customModel;
    private $memberModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $this->productModel = new Product();
        $this->orderModel = new Orders();
        $this->promoModel = new Promotions();
        $this->consultModel = new Consultation();
        $this->customModel = new CustomOrder();
        $this->memberModel = new Memberships();
    }

    public function index()
    {
        // statistik cepat
        $totalProducts = count($this->productModel->all());
        $totalOrders = count($this->orderModel->all());
        $totalPromos = count($this->promoModel->allActive());
        $totalConsult = count($this->consultModel->all());
        $totalCustom = count($this->customModel->allByUser(1)); // placeholder
        $totalMembers = count($this->memberModel->all());

        include __DIR__ . '/../views/admin/dashboard.php';
    }
}
