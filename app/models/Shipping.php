<?php
class Shipping
{
    private $db;
    private $config;

    public function __construct()
    {
        $this->db = DB::getInstance();
        $this->config = require __DIR__ . '/../config_komerce.php';
    }

    /* ----------------------------------------------------
     * KOMERCE API HELPER
     * ---------------------------------------------------- */

    private function callApi($endpoint, $post = null)
    {
        $url = rtrim($this->config['base_url'], '/') . $endpoint;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Nonaktifkan sementara untuk testing
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Nonaktifkan sementara

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Key: " . $this->config['key'],
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        if ($post !== null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        $res = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = "cURL Error (#" . curl_errno($ch) . "): " . curl_error($ch) . " | URL: $url";
            error_log($error);
            curl_close($ch);
            return ['meta' => ['code' => 500, 'message' => $error], 'data' => []];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($res, true) ?: ['meta' => ['code' => 500, 'message' => 'Invalid JSON'], 'data' => []];

        // Tambahkan logging detail
        error_log("API Request: $url");
        error_log("API Response Code: $httpCode");
        error_log("API Raw Response: " . print_r($result, true));

        // Handle error berdasarkan HTTP code
        if ($httpCode !== 200) {
            $errorMsg = $result['meta']['message'] ?? 'HTTP Error ' . $httpCode;
            error_log("API HTTP Error ($httpCode): " . $errorMsg);
            return ['meta' => ['code' => $httpCode, 'message' => $errorMsg], 'data' => []];
        }

        return $result;
    }

    /* ----------------------------------------------------
     * API LOCATION (KOMERCE)
     * ---------------------------------------------------- */

    public function provinces()
    {
        $json = $this->callApi("/destination/province");
        return $json['data'] ?? [];
    }

    public function cities($provinceId)
    {
        $endpoint = "/destination/city/" . urlencode($provinceId);
        $json = $this->callApi($endpoint);
        return $json['data'] ?? [];
    }

    public function districts($cityId)
    {
        $endpoint = "/destination/district/" . urlencode($cityId);
        $json = $this->callApi($endpoint);
        return $json['data'] ?? [];
    }

    // TAMBAHKAN METHOD SUBDISTRICTS KHUSUS UNTUK KOMERCE
    public function subdistricts($districtId)
    {
        $endpoint = "/destination/sub-district/" . urlencode($districtId);
        return $this->callApi($endpoint); // Return response mentah dari API
    }

    // PERBAIKAN METHOD COST UNTUK MENGGUNAKAN SUBDISTRICT
    public function cost($destination, $weight, $courier)
    {
        // Cek apakah destination adalah subdistrict_id atau district_id
        // Berdasarkan test, subdistrict memiliki field 'zip_code'
        $isSubdistrict = preg_match('/^\d+$/', $destination) && strlen($destination) >= 3;

        // Pilih endpoint berdasarkan jenis destination
        $endpoint = $isSubdistrict ?
            "/calculate/sub-district/domestic-cost" :
            "/calculate/district/domestic-cost";

        $post = [
            'origin' => $this->config['origin_city_id'], // Kota asal toko Anda
            'destination' => (string) $destination,
            'weight' => (int) $weight, // dalam gram
            'courier' => strtolower($courier)
        ];

        error_log("Cost calculation request: " . print_r($post, true));
        error_log("Using endpoint: " . $endpoint);

        $json = $this->callApi($endpoint, $post);

        error_log("Cost calculation response: " . print_r($json, true));

        // Handle berbagai format response Komerce
        if (isset($json['data']) && !empty($json['data'])) {
            return $json['data'];
        } elseif (isset($json['results']) && !empty($json['results'])) {
            return $json['results'];
        } elseif (isset($json[0]) && is_array($json[0])) {
            return $json;
        }

        // Fallback ke district jika subdistrict gagal
        if ($isSubdistrict) {
            error_log("Subdistrict cost failed, trying district fallback");
            return $this->cost($this->getParentDistrictId($destination), $weight, $courier);
        }

        return [];
    }

    // Helper method untuk mendapatkan district_id dari subdistrict_id
    private function getParentDistrictId($subdistrictId)
    {
        // Di Komerce, subdistrict ID biasanya mengandung info parent
        // Atau kita bisa query ke API lagi
        // Untuk sementara, gunakan prefix (sesuaikan dengan pola ID Komerce)
        return substr($subdistrictId, 0, -2); // Contoh: 409 -> 4
    }

    public function createShipping($orderId, $courier, $cost)
    {
        $stmt = $this->db->prepare("
            INSERT INTO shippings (order_id, courier, shipping_cost, status, updated_at)
            VALUES (?, ?, ?, 'pending', NOW())
        ");

        return $stmt->execute([$orderId, $courier, $cost]);
    }

    public function updateTracking($orderId, $tracking)
    {
        $stmt = $this->db->prepare("
            UPDATE shippings 
            SET tracking_number = ?, status = 'shipped', updated_at = NOW()
            WHERE order_id = ?
        ");

        return $stmt->execute([$tracking, $orderId]);
    }

    public function updateStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE shippings 
            SET status = ?, updated_at = NOW()
            WHERE order_id = ?
        ");

        return $stmt->execute([$status, $orderId]);
    }

    public function getByOrderId($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM shippings WHERE order_id = ? LIMIT 1");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}