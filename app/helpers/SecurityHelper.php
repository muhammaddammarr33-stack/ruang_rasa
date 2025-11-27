<?php
// app/helpers/SecurityHelper.php
class SecurityHelper
{
    public static function startCsrf()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function csrfInput()
    {
        self::startCsrf();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
    }

    public static function checkCsrf($token)
    {
        self::startCsrf();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function sanitize($str)
    {
        return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
    }

    public static function genToken($len = 24)
    {
        return bin2hex(random_bytes($len));
    }
}
