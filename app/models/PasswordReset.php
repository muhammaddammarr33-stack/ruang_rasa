<?php
require_once __DIR__ . '/DB.php';

class PasswordReset
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    // simpan token reset password
    public function createToken($userId, $token, $type = 'reset')
    {
        $stmt = $this->db->prepare("
            INSERT INTO password_resets (user_id, token, type, created_at)
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$userId, $token, $type]);
    }

    // cari token
    public function findByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE token = ? LIMIT 1");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    // hapus token setelah digunakan
    public function deleteToken($token)
    {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
    }
}
