<?php
// app/controllers/ChatController.php
require_once __DIR__ . '/../models/ChatMessage.php';

// class ChatController {
//     private $chat;
//     public function __construct() {
//         if (session_status() === PHP_SESSION_NONE) session_start();
//         $this->chat = new ChatMessage();
//     }

//     // POST: send message
//     public function send() {
//         header('Content-Type: application/json');
//         if (!isset($_SESSION['user'])) {
//             http_response_code(401);
//             echo json_encode(['error'=>'login required']);
//             exit;
//         }
//         $from = $_SESSION['user']['id'];
//         $consultation = $_POST['consultation_id'] ?? null;
//         $to = $_POST['to_user_id'] ?? null;
//         $message = trim($_POST['message'] ?? '');
//         if ($message === '') {
//             http_response_code(400);
//             echo json_encode(['error'=>'message empty']);
//             exit;
//         }

//         // minimal sanitization: store raw (presentasi escaped on output)
//         $id = $this->chat->create([
//             'consultation_id' => $consultation ?: null,
//             'from_user_id' => $from,
//             'to_user_id' => $to ?: null,
//             'message' => $message
//         ]);
//         echo json_encode(['ok' => true, 'id' => $id, 'created_at' => date('Y-m-d H:i:s')]);
//     }

//     // GET: fetch messages after last_id
//     public function fetch() {
//         header('Content-Type: application/json');
//         if (!isset($_SESSION['user'])) {
//             http_response_code(401); echo json_encode(['error'=>'login required']); exit;
//         }
//         $lastId = (int)($_GET['last_id'] ?? 0);
//         $consultation = $_GET['consultation_id'] ?? null;
//         $rows = $this->chat->fetchAfterId($lastId, $consultation ? (int)$consultation : null);
//         echo json_encode(['data' => $rows]);
//     }

//     // POST: mark messages read (accept array ids)
//     public function markRead() {
//         header('Content-Type: application/json');
//         if (!isset($_SESSION['user'])) { http_response_code(401); echo json_encode(['error'=>'login required']); exit; }
//         $ids = $_POST['ids'] ?? [];
//         if (!is_array($ids)) $ids = [];
//         $this->chat->markRead($ids);
//         echo json_encode(['ok' => true]);
//     }

//     // optional: unread count
//     public function unreadCount() {
//         header('Content-Type: application/json');
//         if (!isset($_SESSION['user'])) { http_response_code(401); echo json_encode(['error'=>'login required']); exit; }
//         $c = $this->chat->unreadCountForUser($_SESSION['user']['id']);
//         echo json_encode(['unread' => $c]);
//     }
// }
