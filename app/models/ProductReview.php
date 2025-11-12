<?php
require_once __DIR__ . '/DB.php';

class ProductReview
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($productId, $userId, $rating, $review)
    {
        $stmt = $this->db->prepare("
            INSERT INTO product_reviews (product_id, user_id, rating, review, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$productId, $userId, $rating, $review]);
    }

    public function getByProduct($productId)
    {
        $stmt = $this->db->prepare("
            SELECT r.*, u.name AS user_name
            FROM product_reviews r
            LEFT JOIN users u ON r.user_id = u.id
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function getStats($productId)
    {
        $stmt = $this->db->prepare("
            SELECT ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS total_reviews
            FROM product_reviews
            WHERE product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetch();
    }
}
