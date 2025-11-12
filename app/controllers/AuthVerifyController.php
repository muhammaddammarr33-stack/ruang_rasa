<?php
// app/controllers/AuthVerifyController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/PasswordReset.php';

class AuthVerifyController
{
    private $userModel;
    private $resetModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->resetModel = new PasswordReset();
    }

    public function verify()
    {
        $token = $_GET['token'] ?? '';

        if (!$token) {
            echo "<h3>❌ Token tidak ditemukan.</h3>";
            return;
        }

        $record = $this->resetModel->findByToken($token, 'verify');
        if (!$record) {
            echo "<h3>❌ Token tidak valid atau sudah kedaluwarsa.</h3>";
            return;
        }

        $this->userModel->verifyEmail($record['user_id']);
        $this->resetModel->deleteToken($token);

        echo "<div style='padding:40px;text-align:center;'>
                <h2>✅ Email kamu sudah diverifikasi!</h2>
                <p><a href='?page=login'>Klik di sini untuk login</a></p>
              </div>";
    }
}
