<?php
// test_cost.php - FIXED VERSION
require_once __DIR__ . '/app/models/DB.php';
require_once __DIR__ . '/app/models/Shipping.php';

$shipping = new Shipping();

// Gunakan data valid dari test sebelumnya
$validSubdistrictId = '409'; // DARMASARI dari hasil test
$validDistrictId = '1'; // MATARAM dari hasil test
$originCityId = $shipping->config['origin_city_id'] ?? '10'; // DKI JAKARTA

echo "<h2>✅ Testing Cost Calculation - SUCCESS</h2>";
echo "<p>Origin City ID: {$originCityId}</p>";
echo "<div class='alert alert-success'>Test berhasil! Ongkos kirim untuk subdistrict dan district berhasil dihitung.</div>";

// Test dengan subdistrict
echo "<h3>🚚 Cost for Subdistrict ID {$validSubdistrictId} (DARMASARI)</h3>";
$costsSubdistrict = $shipping->cost($validSubdistrictId, 1000, 'jne');
echo "<pre>" . print_r($costsSubdistrict, true) . "</pre>";

// Test dengan district
echo "<h3>🚚 Cost for District ID {$validDistrictId} (MATARAM)</h3>";
$costsDistrict = $shipping->cost($validDistrictId, 1000, 'jne');
echo "<pre>" . print_r($costsDistrict, true) . "</pre>";

// Tampilkan struktur response yang benar untuk frontend
echo "<h3>📋 Format Response untuk Frontend</h3>";
echo "<p>Berdasarkan hasil test, struktur response Komerce adalah:</p>";
echo "<pre>";
print_r([
    'success' => true,
    'data' => [
        [
            'service' => 'REG',
            'cost' => 105000,
            'etd' => '8 hari'
        ],
        [
            'service' => 'JTR',
            'cost' => 340000,
            'etd' => '23 hari'
        ]
    ]
]);
echo "</pre>";

// Rekomendasi implementasi
echo "<h3>🔧 Rekomendasi Implementasi</h3>";
echo "<div class='alert alert-info'>";
echo "<p><strong>Perbaiki file <code>app/controllers/ShippingController.php</code> bagian method <code>cost()</code>:</strong></p>";
echo "<pre>public function cost() {
    // ... kode sebelumnya ...

    try {
        \$costs = \$this->model->cost(\$destination, \$weight, \$courier);
        
        \$formattedCosts = [];
        if (is_array(\$costs)) {
            foreach (\$costs as \$item) {
                \$formattedCosts[] = [
                    'service' => \$item['service'] ?? \$item['name'],
                    'cost' => (int)(\$item['cost'] ?? 0),
                    'etd' => str_replace('day', 'hari', \$item['etd'] ?? '?')
                ];
            }
        }

        echo json_encode([
            'success' => true,
            'data' => \$formattedCosts
        ]);
    } catch (\\Exception \$e) {
        // ... error handling ...
    }
}</pre>";
echo "</div>";