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
        // FULL URL
        $url = rtrim($this->config['base_url'], '/') . $endpoint;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Memastikan sertifikat SSL valid untuk produksi (jika tidak, hapus 2 baris ini)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            // Menggunakan "Key" (huruf kapital) sesuai API Komerce/cURL
            "Key: " . $this->config['key'],
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        // POST METHOD
        if ($post !== null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        $res = curl_exec($ch);

        if (curl_errno($ch)) {
            // Penanganan error curl
            // Biasanya terjadi jika koneksi terputus atau timeout
            error_log("cURL Error for $url: " . curl_error($ch));
            return ['meta' => ['message' => 'Internal cURL Error'], 'data' => []];
        }

        curl_close($ch);
        $result = json_decode($res, true);

        // Logging jika API mengembalikan error
        if (isset($result['meta']['code']) && $result['meta']['code'] !== 200) {
            error_log("API Error $url: " . $result['meta']['message']);
        }

        return $result;
    }

    /* ----------------------------------------------------
     * API LOCATION
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
    // app/models/Shipping.php

    // ...
    public function districts($cityId)
    {
        // Endpoint untuk mendapatkan district di dalam city
        $endpoint = "/destination/district/" . urlencode($cityId);
        $json = $this->callApi($endpoint);

        // Perhatikan: Kadang API Komerce memerlukan Key berbeda untuk endpoint ini.
        return $json['data'] ?? [];
    }

    public function cost($destination, $weight, $courier)
    {
        // Menggunakan key V2 (yang paling sering berhasil di Komerce)
        $post = [
            'origin' => $this->config['origin_city_id'], // Menggunakan ID Kota Asal Toko
            'destination' => (string) $destination, // Harus ID Distrik/Kecamatan/Kota Tujuan
            'weight' => (int) $weight, // Harus dalam gram
            'courier' => (string) strtolower($courier) // Harus huruf kecil
        ];

        // Menggunakan endpoint yang berhasil Anda uji
        $json = $this->callApi("/calculate/district/domestic-cost", $post);

        return $json['data'] ?? $json['results'] ?? [];
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