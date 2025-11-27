<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserSession.php';
require_once __DIR__ . '/../models/PasswordReset.php';
require_once __DIR__ . '/../helpers/SecurityHelper.php';
require_once __DIR__ . '/../helpers/MailHelper.php';

class AuthController
{
    private $userModel;
    private $sessionModel;
    private $resetModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->sessionModel = new UserSession();
        $this->resetModel = new PasswordReset();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        SecurityHelper::startCsrf();
    }

    // show forms
    public function showRegister()
    {
        include __DIR__ . '/../views/auth/register.php';
    }
    public function showLogin()
    {
        include __DIR__ . '/../views/auth/login.php';
    }
    public function showForgot()
    {
        include __DIR__ . '/../views/auth/forgot.php';
    }
    public function showReset()
    {
        include __DIR__ . '/../views/auth/reset.php';
    }

    // register
    // app/controllers/AuthController.php
    public function register()
    {
        try {
            if (!SecurityHelper::checkCsrf($_POST['csrf_token'] ?? ''))
                throw new Exception("CSRF token invalid");

            $name = SecurityHelper::sanitize($_POST['name'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';
            $phone = SecurityHelper::sanitize($_POST['phone'] ?? '');
            $address = SecurityHelper::sanitize($_POST['address'] ?? '');

            if (!$email)
                throw new Exception("Email tidak valid");
            if (strlen($password) < 6)
                throw new Exception("Password minimal 6 karakter");

            // cek email sudah ada?
            if ($this->userModel->findByEmail($email))
                throw new Exception("Email sudah terdaftar");

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $userId = $this->userModel->create($name, $email, $passwordHash, $phone, $address);

            // create verify token
            $token = SecurityHelper::genToken(24);
            $this->resetModel->createToken($userId, $token, 'verify', $email);

            $link = BASE_URL . "?page=auth_verify&token=" . urlencode($token);
            $body = "<p>Halo {$name},</p>
<p>Silakan klik link berikut untuk verifikasi email Anda:</p>
<p><a href='{$link}'>{$link}</a></p>
<p>Terima kasih, tim Ruang Rasa 💌</p>";

            MailHelper::send($email, "Verifikasi Email Ruang Rasa", $body);

            $_SESSION['success'] = "Registrasi berhasil. Silakan cek email kamu untuk verifikasi.";
            header("Location: ?page=login");
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: ?page=register");
            exit;
        }
    }

    // verify email
    public function verify()
    {
        $token = $_GET['token'] ?? '';
        if (!$token) {
            $_SESSION['error'] = "Token tidak ditemukan";
            header("Location: ?page=login");
            return;
        }
        $row = $this->resetModel->findByToken($token, 'verify');
        if (!$row) {
            $_SESSION['error'] = "Token invalid atau sudah digunakan";
            header("Location: ?page=login");
            return;
        }
        $this->userModel->verifyEmail($row['user_id']);
        $this->resetModel->deleteToken($token);
        $_SESSION['success'] = "Email berhasil diverifikasi. Silakan login.";
        header("Location: ?page=login");
    }

    // login
    public function login()
    {
        try {
            if (!SecurityHelper::checkCsrf($_POST['csrf_token'] ?? ''))
                throw new Exception("CSRF token invalid");

            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || !$password)
                throw new Exception("Email dan password wajib diisi");

            $user = $this->userModel->findByEmail($email);
            if (!$user)
                throw new Exception("Email tidak ditemukan");

            if (!password_verify($password, $user['password']))
                throw new Exception("Password salah");

            // ✅ tambahan verifikasi email
            if ($user['role'] === 'customer' && !$user['email_verified']) {
                throw new Exception("Akun belum diverifikasi. Silakan cek email kamu untuk aktivasi.");
            }

            // ✅ jika status user nonaktif/banned
            if ($user['status'] !== 'active') {
                throw new Exception("Akun kamu tidak aktif atau diblokir.");
            }

            // kalau semua aman → login berhasil
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            $_SESSION['success'] = "Selamat datang, {$user['name']}!";

            // arahkan berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: ?page=admin_dashboard");
            } elseif ($user['role'] === 'consultant') {
                header("Location: ?page=consultant_dashboard");
            } else {
                header("Location: ?page=landing");
            }
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: ?page=login");
            exit;
        }
    }

    // logout
    public function logout()
    {
        $token = $_SESSION['session_token'] ?? null;
        if ($token)
            $this->sessionModel->removeByToken($token);
        session_unset();
        session_destroy();
        header("Location: ?page=login");
        exit;
    }

    // forgot (send reset)
    public function forgot()
    {
        try {
            if (!SecurityHelper::checkCsrf($_POST['csrf_token'] ?? ''))
                throw new Exception("CSRF token invalid");
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            if (!$email)
                throw new Exception("Email tidak valid");
            $user = $this->userModel->findByEmail($email);
            if (!$user)
                throw new Exception("Email tidak terdaftar");

            $token = SecurityHelper::genToken(24);
            $this->resetModel->createToken($user['id'], $token, 'reset', $email);

            $link = $this->makeBaseUrl() . "?page=auth_reset&token=" . urlencode($token);
            $body = "<p>Halo {$user['name']},</p><p>Gunakan link berikut untuk reset password:</p><p><a href='{$link}'>{$link}</a></p>";
            MailHelper::send($email, "Reset Password Ruang Rasa", $body);

            $_SESSION['success'] = "Link reset telah dikirim ke email.";
            header("Location: ?page=login");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: ?page=auth_forgot");
            exit;
        }
    }

    // reset (handle form)
    public function reset()
    {
        $token = $_GET['token'] ?? ($_POST['token'] ?? null);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!SecurityHelper::checkCsrf($_POST['csrf_token'] ?? ''))
                    throw new Exception("CSRF token invalid");
                $token = $_POST['token'] ?? '';
                $row = $this->resetModel->findByToken($token, 'reset');
                if (!$row)
                    throw new Exception("Token tidak valid");
                $password = $_POST['password'] ?? '';
                if (strlen($password) < 6)
                    throw new Exception("Password minimal 6 karakter");
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $this->userModel->setPassword($row['user_id'], $hash);
                $this->resetModel->deleteToken($token);
                $_SESSION['success'] = "Password berhasil diubah.";
                header("Location: ?page=login");
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: ?page=auth_reset&token=" . urlencode($token));
                exit;
            }
        } else {
            include __DIR__ . '/../views/auth/reset.php';
        }
    }

    private function makeBaseUrl()
    {
        $script = $_SERVER['SCRIPT_NAME'] ?? '/public/index.php';
        $host = ($_SERVER['HTTP_HOST'] ?? 'localhost');
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $scheme . '://' . $host . $script;
    }
}
