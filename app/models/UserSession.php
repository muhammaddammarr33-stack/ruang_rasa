<?php
// app/models/UserSession.php
require_once __DIR__ . '/DB.php';

class UserSession
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($userId, $token, $ip, $agent)
    {
        $stmt = $this->db->prepare("
            INSERT INTO user_sessions (user_id, session_token, ip_address, user_agent, last_activity)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$userId, $token, $ip, $agent]);
    }

    public function removeByToken($token)
    {
        $stmt = $this->db->prepare("DELETE FROM user_sessions WHERE session_token = ?");
        $stmt->execute([$token]);
    }

    public function purgeOld($minutes = 60)
    {
        $stmt = $this->db->prepare("DELETE FROM user_sessions WHERE last_activity < DATE_SUB(NOW(), INTERVAL ? MINUTE)");
        $stmt->execute([$minutes]);
    }
}
