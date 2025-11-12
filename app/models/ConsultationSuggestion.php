<?php
require_once __DIR__ . '/DB.php';

class ConsultationSuggestion
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($consultationId, $productId, $reason)
    {
        $stmt = $this->db->prepare("
            INSERT INTO consultation_suggestions (consultation_id, product_id, reason, created_at)
            VALUES (?, ?, ?, NOW())
        ");
        return $stmt->execute([$consultationId, $productId, $reason]);
    }

    public function getByConsultation($consultationId)
    {
        $stmt = $this->db->prepare("
            SELECT cs.*, p.name AS product_name, p.price 
            FROM consultation_suggestions cs
            JOIN products p ON cs.product_id = p.id
            WHERE cs.consultation_id = ?
        ");
        $stmt->execute([$consultationId]);
        return $stmt->fetchAll();
    }
}
