<?php
require_once __DIR__ . '/../models/DB.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Pusher\Pusher;

class ConsultationChatController
{
    private $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Login dulu']);
            exit;
        }

        $allowedRoles = ['admin', 'user', 'customer'];
        $currentRole = strtolower($_SESSION['user']['role'] ?? '');

        if (!in_array($currentRole, $allowedRoles)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Role tidak diizinkan']);
            exit;
        }

        $this->db = DB::getInstance();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function sendMessage()
    {
        $consultationId = $_POST['consultation_id'] ?? null;
        $senderId = $_SESSION['user']['id'];
        $msg = trim($_POST['message'] ?? '');
        if (!$consultationId || $msg === '')
            return;

        // 🔍 Deteksi apakah ini perintah produk
        $message_type = 'text';
        $product_id = null;

        if (preg_match('/^!produk:(\d+)$/', $msg, $matches)) {
            $product_id = (int) $matches[1];
            // Validasi produk
            $prodCheck = $this->db->prepare("
                SELECT p.id 
                FROM products p 
                WHERE p.id = ? AND p.stock > 0
            ");
            $prodCheck->execute([$product_id]);
            if ($prodCheck->fetch()) {
                $message_type = 'product';
                // Simpan NAMA PRODUK, bukan "!produk:123"
                $nameStmt = $this->db->prepare("SELECT name FROM products WHERE id = ?");
                $nameStmt->execute([$product_id]);
                $msg = $nameStmt->fetchColumn() ?: "Produk ID $product_id";
            }
        }

        // ✅ Simpan dengan tipe yang benar
        $stmt = $this->db->prepare("
            INSERT INTO consultation_messages 
            (consultation_id, sender_id, message, message_type, product_id, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$consultationId, $senderId, $msg, $message_type, $product_id]);

        // Ambil nama pengirim
        $userStmt = $this->db->prepare("SELECT name FROM users WHERE id = ?");
        $userStmt->execute([$senderId]);
        $name = $userStmt->fetchColumn() ?: 'User';

        // 🔥 Kirim data lengkap ke Pusher
        $pusherData = [
            'sender_id' => $senderId,
            'message' => $msg,
            'message_type' => $message_type,
            'name' => $name,
            'time' => date('H:i')
        ];

        // Jika produk, tambahkan data gambar & harga
        if ($message_type === 'product') {
            $prodData = $this->db->prepare("
                SELECT p.price, pi.image_path
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
                WHERE p.id = ?
            ");
            $prodData->execute([$product_id]);
            $prod = $prodData->fetch();

            if ($prod) {
                $pusherData['product_id'] = $product_id;
                $pusherData['product_price'] = $prod['price'];
                $pusherData['product_image'] = $prod['image_path'];
            }
        }

        // Kirim via Pusher
        $pusher = new Pusher("5bff370a5bd607d4280f", "f75608a929bee783bd01", "2079295", [
            'cluster' => 'ap1',
            'useTLS' => true
        ]);
        $pusher->trigger("consultation_$consultationId", 'new_message', $pusherData);
    }

    public function fetchMessages()
    {
        $consultationId = $_GET['id'] ?? null;
        if (!$consultationId) {
            echo json_encode([]);
            return;
        }

        try {
            // ✅ Ambil semua data termasuk produk
            $stmt = $this->db->prepare("
                SELECT 
                    m.*,
                    u.name,
                    pi.image_path as product_image,
                    p.price as product_price
                FROM consultation_messages m
                JOIN users u ON u.id = m.sender_id
                LEFT JOIN products p ON p.id = m.product_id
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
                WHERE m.consultation_id = ?
                ORDER BY m.created_at ASC
            ");
            $stmt->execute([$consultationId]);
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($messages as &$msg) {
                $msg['time'] = date('H:i', strtotime($msg['created_at']));
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($messages);
        } catch (Exception $e) {
            error_log("Fetch error: " . $e->getMessage());
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([]);
        }
    }
}