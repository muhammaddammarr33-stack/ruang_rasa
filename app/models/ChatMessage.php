<?php
// app/models/ChatMessage.php
require_once __DIR__ . '/DB.php';

class ChatMessage
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO chat_messages (consultation_id, from_user_id, to_user_id, message, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $data['consultation_id'] ?? null,
            $data['from_user_id'],
            $data['to_user_id'] ?? null,
            $data['message']
        ]);
        return $this->db->lastInsertId();
    }

    // ambil pesan setelah id tertentu (untuk polling incremental)
    public function fetchAfterId($lastId = 0, $consultationId = null, $limit = 100)
    {
        if ($consultationId) {
            $stmt = $this->db->prepare("
                SELECT cm.*, u.name AS from_name
                FROM chat_messages cm
                LEFT JOIN users u ON u.id = cm.from_user_id
                WHERE cm.id > ? AND cm.consultation_id = ?
                ORDER BY cm.id ASC
                LIMIT ?
            ");
            $stmt->execute([$lastId, $consultationId, $limit]);
        } else {
            $stmt = $this->db->prepare("
                SELECT cm.*, u.name AS from_name
                FROM chat_messages cm
                LEFT JOIN users u ON u.id = cm.from_user_id
                WHERE cm.id > ?
                ORDER BY cm.id ASC
                LIMIT ?
            ");
            $stmt->execute([$lastId, $limit]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markRead($ids = [])
    {
        if (empty($ids))
            return false;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE chat_messages SET is_read = 1 WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    public function unreadCountForUser($userId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as cnt FROM chat_messages WHERE to_user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return (int) ($stmt->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0);
    }
}
