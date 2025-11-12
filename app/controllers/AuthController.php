<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    public function showLogin()
    {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister()
    {
        include __DIR__ . '/../views/auth/register.php';
    }

    public function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if (!$name || !$email || !$password) {
            $_SESSION['error'] = "Isi semua field";
            header("Location: ?page=register");
            exit;
        }
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email sudah terdaftar";
            header("Location: ?page=register");
            exit;
        }
        $this->userModel->create($name, $email, $password);
        $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
        header("Location: ?page=login");
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Email atau password salah";
            header("Location: ?page=login");
            exit;
        }
        // set session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        // redirect based on role: admin -> admin dashboard, else landing
        if ($user['role'] === 'admin') {
            header("Location: ?page=admin_dashboard");
        } else {
            header("Location: ?page=home");
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?page=home");
    }
}
