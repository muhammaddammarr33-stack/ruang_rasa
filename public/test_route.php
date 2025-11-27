<?php
// public/test_route.php
require_once __DIR__ . '/../app/controllers/ShippingController.php';

// Simulasi request
$_GET['district_id'] = '40';
$_GET['page'] = 'shipping_subdistricts';

error_log("=== TESTING SUBDISTRICTS ROUTE ===");

try {
    $controller = new ShippingController();
    $controller->subdistricts();
} catch (\Exception $e) {
    error_log("Route test failed: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}