<?php
// test_api.php
require_once __DIR__ . '/app/models/DB.php';
require_once __DIR__ . '/app/models/Shipping.php';

$shipping = new Shipping();

// Ganti dengan district_id yang valid dari hasil cities/districts
$districtId = '39'; // Contoh ID Kecamatan Cengkareng

echo "<h2>Testing Subdistricts for District ID: {$districtId}</h2>";

// Test provinces
echo "<h3>Provinces:</h3>";
$provinces = $shipping->provinces();
echo "<pre>" . print_r($provinces, true) . "</pre>";

// Test cities (ambil province_id dari hasil provinces)
$provinceId = $provinces[0]['id'] ?? '1';
echo "<h3>Cities for Province ID {$provinceId}:</h3>";
$cities = $shipping->cities($provinceId);
echo "<pre>" . print_r($cities, true) . "</pre>";

// Test districts (ambil city_id dari hasil cities)
$cityId = $cities[0]['id'] ?? '1';
echo "<h3>Districts for City ID {$cityId}:</h3>";
$districts = $shipping->districts($cityId);
echo "<pre>" . print_r($districts, true) . "</pre>";

// Test subdistricts
echo "<h3>Subdistricts for District ID {$districtId}:</h3>";
$subdistricts = $shipping->subdistricts($districtId);
echo "<pre>" . print_r($subdistricts, true) . "</pre>";

// Test cost calculation (jika ada subdistrict yang valid)
if (!empty($subdistricts)) {
    $subdistrictId = $subdistricts[0]['id'] ?? $districtId;
    echo "<h3>Cost Calculation for Subdistrict ID {$subdistrictId}:</h3>";
    $costs = $shipping->cost($subdistrictId, 1000, 'jne'); // 1kg, JNE
    echo "<pre>" . print_r($costs, true) . "</pre>";
}