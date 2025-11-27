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

    public function provinces()
    {
        header('Content-Type: application/json');
        $provinces = $this->model->provinces();

        // Format ulang untuk kompatibilitas dengan frontend
        $formatted = [];
        foreach ($provinces as $p) {
            $formatted[] = [
                'province_id' => $p['id'],
                'province' => $p['name']
            ];
        }

        echo json_encode([
            'success' => true,
            'data' => $formatted
        ]);
    }

    public function cities()
    {
        $provinceId = $_GET['province_id'] ?? null;
        header('Content-Type: application/json');

        if (empty($provinceId)) {
            echo json_encode(['success' => false, 'data' => []]);
            exit;
        }

        $cities = $this->model->cities($provinceId);

        // Format ulang untuk kompatibilitas dengan frontend
        $formatted = [];
        foreach ($cities as $c) {
            $formatted[] = [
                'city_id' => $c['id'],
                'type' => $c['type'] ?? 'Kota',
                'city_name' => $c['name']
            ];
        }

        echo json_encode([
            'success' => true,
            'data' => $formatted
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

            // Format untuk kompatibilitas frontend
            $formatted = [];
            foreach ($districts as $d) {
                $formatted[] = [
                    'district_id' => $d['id'],
                    'district_name' => $d['name']
                ];
            }

            echo json_encode(['success' => true, 'data' => $formatted]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }

    // TAMBAHKAN METHOD SUBDISTRICTS
    public function subdistricts()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $districtId = $_GET['district_id'] ?? null;

        if (empty($districtId) || !is_numeric($districtId)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'District ID tidak valid',
                'data' => []
            ]);
            exit;
        }

        try {
            // Ambil data dari model
            $subdistricts = $this->model->subdistricts($districtId);

            // Format data sesuai struktur API Komerce yang sebenarnya
            $formatted = [];
            if (isset($subdistricts['data']) && is_array($subdistricts['data'])) {
                foreach ($subdistricts['data'] as $s) {
                    $formatted[] = [
                        'subdistrict_id' => (string) $s['id'], // Convert ke string
                        'subdistrict_name' => $s['name']
                    ];
                }
            }

            // Jika tidak ada data tapi API sukses, kirim pesan informatif
            if (empty($formatted) && isset($subdistricts['meta']['code']) && $subdistricts['meta']['code'] == 200) {
                $formatted = [
                    [
                        'subdistrict_id' => $districtId . '_default',
                        'subdistrict_name' => 'Gunakan alamat lengkap tanpa kelurahan spesifik'
                    ]
                ];
            }

            echo json_encode([
                'success' => true,
                'data' => $formatted,
                'count' => count($formatted),
                'debug' => [
                    'district_id' => $districtId,
                    'raw_response' => $subdistricts
                ]
            ]);
        } catch (\Exception $e) {
            error_log("Subdistricts error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function cost()
    {
        header('Content-Type: application/json');

        $destination = $_POST['destination'] ?? null;
        $courier = $_POST['courier'] ?? null;
        $weight = (int) ($_POST['weight'] ?? 1) * 1000; // KG to gram

        if (!$destination || !$courier || $weight <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Parameter tidak lengkap. Pastikan alamat dan kurir dipilih.',
                'data' => []
            ]);
            exit;
        }

        try {
            $costs = $this->model->cost($destination, $weight, $courier);

            // Format ulang response sesuai struktur Komerce yang sebenarnya
            $formattedCosts = [];

            if (is_array($costs)) {
                foreach ($costs as $item) {
                    // Handle format response Komerce yang sebenarnya
                    $formattedCosts[] = [
                        'service' => $item['service'] ?? $item['name'] ?? 'REG',
                        'cost' => (int) ($item['cost'] ?? 0),
                        'etd' => preg_replace('/(\d+)\s*day/i', '$1 hari', $item['etd'] ?? '?')
                    ];
                }
            }

            // Jika data kosong tapi API sukses, berikan pesan informatif
            if (empty($formattedCosts) && !empty($costs)) {
                $formattedCosts = [
                    [
                        'service' => 'CUSTOM',
                        'cost' => 0,
                        'etd' => 'Hubungi admin untuk konfirmasi'
                    ]
                ];
            }

            echo json_encode([
                'success' => true,
                'data' => $formattedCosts
            ]);
        } catch (\Exception $e) {
            error_log("Cost calculation error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghitung ongkos kirim: ' . $e->getMessage(),
                'data' => []
            ]);
        }
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