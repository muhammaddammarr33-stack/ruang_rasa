<?php
// app/models/DB.php
class DB
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $cfg = include __DIR__ . '/../../config/database.php';
        $dsn = "mysql:host={$cfg['DB_HOST']};dbname={$cfg['DB_NAME']};charset={$cfg['DB_CHAR']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,            // lempar exception kalau error
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // hasil query berupa array asosiatif
            PDO::ATTR_PERSISTENT => false,                          // hindari koneksi persistent (lebih aman di dev)
        ];

        try {
            $this->pdo = new PDO($dsn, $cfg['DB_USER'], $cfg['DB_PASS'], $options);
        } catch (PDOException $e) {
            // tulis ke log agar tidak tampil di layar (lebih aman)
            error_log("Database connection failed: " . $e->getMessage());
            die("⚠️ Tidak dapat terhubung ke database. Silakan periksa konfigurasi.");
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance->pdo;
    }
}
