<?php
require_once __DIR__ . '/DB.php';

class ConsultationFeedback
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($consultationId, $satisfaction, $followUp, $whatsappLink = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO consultation_feedback (consultation_id, satisfaction, follow_up, whatsapp_link, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$consultationId, $satisfaction, $followUp, $whatsappLink]);
    }
}
