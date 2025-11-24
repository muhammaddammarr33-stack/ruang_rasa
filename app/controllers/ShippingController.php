<?php

require_once __DIR__ . '/../models/Shipping.php';
require_once __DIR__ . '/../models/Order.php';

class ShippingController
{
    private $model;

    public function __construct()
    {
        $this->model = new Shipping();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    /* --------------------------------------
     * API AJAX (Location)
     * -------------------------------------- */

    public function provinces()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $this->model->provinces()
        ]);
    }

    public function cities()
    {
        // Gunakan operator null coalescing (??) untuk keamanan
        $provinceId = $_GET['province_id'] ?? null;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $this->model->cities($provinceId)
        ]);
    }
    public function districts()
    {
        header('Content-Type: application/json');

        $cityId = $_GET['city_id'] ?? null;

        if (empty($cityId)) {
            echo json_encode(['success' => false, 'data' => []]);
            exit;
        }

        try {
            $districts = $this->model->districts($cityId);
            echo json_encode(['success' => true, 'data' => $districts]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }

    // CATATAN: Fungsi districts() dihapus karena endpoint tidak didukung
    // atau memerlukan ID kota dari form POST/GET. Jika ingin menggunakannya,
    // disarankan untuk menggunakan metode 'Direct Search' API Komerce.

    /* --------------------------------------
     * API AJAX (Cost Calculation)
     * -------------------------------------- */

    // app/controllers/ShippingController.php

    // ... (Bagian require_once dan class ShippingController)

    // app/controllers/ShippingController.php
    public function cost()
    {
        header('Content-Type: application/json');

        $destination = $_POST['destination'] ?? null;
        $courier = $_POST['courier'] ?? null;
        $weight = (int) ($_POST['weight'] ?? 1) * 1000; // Asumsi JS kirim KG

        // PENTING: Origin ID harus disetel di config_komerce.php

        // --- PANGGILAN API YANG SEBENARNYA ---
        try {
            $costs = $this->model->cost($destination, $weight, $courier);

            echo json_encode([
                'success' => true,
                'data' => $costs
            ]);
        } catch (\Exception $e) {
            // Mengembalikan error ke console browser
            echo json_encode(['success' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
        // --- END PANGGILAN API ---
    }

    /* --------------------------------------
     * AFTER CHECKOUT (Database Operations)
     * -------------------------------------- */

    public function createAfterCheckout($orderId, $courier, $cost)
    {
        return $this->model->createShipping($orderId, $courier, $cost);
    }

    /* --------------------------------------
     * ADMIN UPDATE (Database Operations)
     * -------------------------------------- */

    public function updateTracking()
    {
        $orderId = $_POST['order_id'] ?? null;
        $tracking = $_POST['tracking_number'] ?? null;

        if ($orderId && $tracking) {
            $this->model->updateTracking($orderId, $tracking);
        }

        header("Location: ?page=admin_order_detail&id=" . $orderId);
    }

    public function updateStatus()
    {
        $orderId = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($orderId && $status) {
            $this->model->updateStatus($orderId, $status);
        }

        header("Location: ?page=admin_order_detail&id=" . $orderId);
    }
}