<?php
// api_debug.php - SOLUSI FLEKSIBEL (CARI CONFIG DI BERBAGAI LOKASI)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$districtId = $_GET['district_id'] ?? '39'; // Default Cengkareng

try {
    $config = null;
    $configPaths = [
        // Coba di root project
        __DIR__ . '/config_komerce.php',
        // Coba di folder app
        __DIR__ . '/app/config_komerce.php',
        // Coba di folder config
        __DIR__ . '/config/config_komerce.php',
        // Coba di lokasi relatif dari file ini
        dirname(__DIR__) . '/config_komerce.php',
        // Coba path absolut (sesuaikan dengan instalasi XAMPP Anda)
        'C:/xampp/htdocs/ruang_rasa/config_komerce.php',
        'C:/xampp/htdocs/ruang_rasa/app/config_komerce.php'
    ];

    // Cari file config yang ada
    foreach ($configPaths as $path) {
        if (file_exists($path)) {
            $config = require $path;
            $foundPath = $path;
            break;
        }
    }

    if (!$config) {
        throw new Exception("Config file not found in any of these locations:\n" . implode("\n", $configPaths));
    }

    // Validasi config minimal
    if (!isset($config['key']) || empty($config['key'])) {
        throw new Exception("Config file found but missing 'key' value");
    }

    if (!isset($config['base_url']) || empty($config['base_url'])) {
        throw new Exception("Config file found but missing 'base_url' value");
    }

    // Ambil data langsung dari API
    $endpoint = "/destination/sub-district/{$districtId}";
    $url = rtrim($config['base_url'], '/') . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Key: " . $config['key'],
        "Accept: application/json"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    echo json_encode([
        'status' => $httpCode === 200 ? 'success' : 'error',
        'config_found_at' => $foundPath ?? 'not found',
        'raw_url' => $url,
        'http_code' => $httpCode,
        'curl_error' => $curlError,
        'raw_response' => $data,
        'api_key_used' => substr($config['key'], 0, 4) . '*** (hidden)',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'config_search_paths' => [
            __DIR__ . '/config_komerce.php',
            __DIR__ . '/app/config_komerce.php',
            __DIR__ . '/config/config_komerce.php',
            dirname(__DIR__) . '/config_komerce.php',
            'C:/xampp/htdocs/ruang_rasa/config_komerce.php',
            'C:/xampp/htdocs/ruang_rasa/app/config_komerce.php'
        ]
    ], JSON_PRETTY_PRINT);
}