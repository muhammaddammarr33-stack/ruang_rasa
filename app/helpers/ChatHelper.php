<?php
function getUnreadConsultationCount($userId)
{
    $db = DB::getInstance();
    $stmt = $db->prepare("
        SELECT COUNT(*)
        FROM consultation_messages m
        JOIN consultations c ON c.id = m.consultation_id
        WHERE c.user_id = ? 
          AND m.sender_id != ? 
          AND c.status IN ('suggested', 'in_progress')
          AND (c.last_read_at IS NULL OR m.created_at > c.last_read_at)
    ");
    $stmt->execute([$userId, $userId]);
    return (int) $stmt->fetchColumn();
}

function getUnreadConsultationsForAdmin()
{
    $db = DB::getInstance();
    $stmt = $db->prepare("
        SELECT COUNT(DISTINCT c.id)
        FROM consultations c
        JOIN consultation_messages m ON m.consultation_id = c.id
        WHERE c.status IN ('submitted', 'suggested', 'in_progress')
          AND m.sender_id != (SELECT id FROM users WHERE role = 'admin' LIMIT 1)
          AND (c.last_read_at IS NULL OR m.created_at > c.last_read_at)
    ");
    $stmt->execute();
    return (int) $stmt->fetchColumn();
}