<?php
// app/models/PasswordReset.php
require_once __DIR__ . '/DB.php';
class PasswordReset
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function createToken($userId, $token, $type = 'reset')
    {
        $stmt = $this->db->prepare("
        INSERT INTO password_resets (user_id, token, type, created_at)
        VALUES (?, ?, ?, NOW())
    ");
        $stmt->execute([$userId, $token, $type]);
        return $this->db->lastInsertId();
    }


    public function findByToken($token, $type = null)
    {
        if ($type) {
            $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE token = ? AND type = ?");
            $stmt->execute([$token, $type]);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE token = ?");
            $stmt->execute([$token]);
        }
        return $stmt->fetch();
    }

    public function deleteToken($token)
    {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
    }
}
