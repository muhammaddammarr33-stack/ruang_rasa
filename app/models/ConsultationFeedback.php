<?php
require_once __DIR__ . '/DB.php';

class ConsultationFeedback
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    // Hanya terima 3 parameter: consultation_id, satisfaction, follow_up
    public function create($consultationId, $satisfaction, $followUp)
    {
        $sql = "INSERT INTO consultation_feedback
                (consultation_id, satisfaction, follow_up, created_at)
                VALUES (?, ?, ?, NOW())";
        return $this->db->prepare($sql)->execute([
            $consultationId,
            $satisfaction,
            $followUp
        ]);
    }

    public function getByConsultation($id)
    {
        $q = $this->db->prepare("SELECT * FROM consultation_feedback WHERE consultation_id=?");
        $q->execute([$id]);
        return $q->fetch();
    }
}