<?php
// Asumsikan file DB.php dan config_komerce.php ada di lokasi yang benar
require_once 'app/models/DB.php'; // Ganti dengan path DB Anda yang benar
require_once 'app/models/Shipping.php'; // Ganti dengan path Shipping.php Anda yang benar

try {
    $shipping = new Shipping();
    $provinces = $shipping->provinces();

    // Output sederhana
    header('Content-Type: application/json');
    if (empty($provinces)) {
        echo json_encode(['status' => 'Gagal', 'data' => 'Key Ditolak/Data Kosong']);
    } else {
        echo json_encode(['status' => 'Sukses', 'jumlah_provinsi' => count($provinces)]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'Error', 'message' => $e->getMessage()]);
}