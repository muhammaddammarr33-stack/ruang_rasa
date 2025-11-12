<?php
require_once __DIR__ . '/DB.php';

class CustomOrder
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($userId, $productId, $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO custom_orders
            (user_id, product_id, custom_text, font_style, text_color, packaging_type, ribbon_color, special_instructions, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'draft', NOW(), NOW())
        ");
        $stmt->execute([
            $userId,
            $productId,
            $data['custom_text'],
            $data['font_style'],
            $data['text_color'],
            $data['packaging_type'],
            $data['ribbon_color'],
            $data['special_instructions']
        ]);
        return $this->db->lastInsertId();
    }

    public function allByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT co.*, p.name AS product_name
            FROM custom_orders co
            JOIN products p ON co.product_id = p.id
            WHERE co.user_id = ?
            ORDER BY co.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT co.*, p.name AS product_name, p.price
            FROM custom_orders co
            JOIN products p ON co.product_id = p.id
            WHERE co.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE custom_orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $id]);
    }

    public function linkToOrder($customId, $orderId)
    {
        $stmt = $this->db->prepare("UPDATE custom_orders SET order_id = ?, status = 'ordered' WHERE id = ?");
        $stmt->execute([$orderId, $customId]);
    }
}
