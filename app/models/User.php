<?php
// app/models/User.php
require_once __DIR__ . '/DB.php';

class User
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($name, $email, $passwordHash, $phone = '', $address = '', $role = 'customer')
    {
        $stmt = $this->db->prepare("INSERT INTO users (name,email,password,phone,address,role,email_verified,status,created_at) VALUES (?,?,?,?,?,? ,0,'active',NOW())");
        $stmt->execute([$name, $email, $passwordHash, $phone, $address, $role]);
        return $this->db->lastInsertId();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function verifyEmail($userId)
    {
        $stmt = $this->db->prepare("UPDATE users SET email_verified = 1 WHERE id = ?");
        $stmt->execute([$userId]);
    }

    public function updateProfile($userId, $name, $phone, $address, $profileImage = null)
    {
        if ($profileImage) {
            $stmt = $this->db->prepare("UPDATE users SET name=?, phone=?, address=?, profile_image=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([$name, $phone, $address, $profileImage, $userId]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET name=?, phone=?, address=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([$name, $phone, $address, $userId]);
        }
    }

    public function setPassword($userId, $passwordHash)
    {
        $stmt = $this->db->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->execute([$passwordHash, $userId]);
    }
}
