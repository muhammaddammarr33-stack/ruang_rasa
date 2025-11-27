<?php
require_once __DIR__ . '/../models/Rewards.php';

class UserRewardHistoryController
{
    private $rewardModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validasi session lengkap
        if (
            !isset($_SESSION['user']) ||
            !isset($_SESSION['user']['id']) ||
            !is_numeric($_SESSION['user']['id']) ||
            $_SESSION['user']['id'] <= 0
        ) {
            $_SESSION['error'] = "Silakan login untuk mengakses riwayat reward";
            header("Location: ?page=login");
            exit;
        }

        $this->rewardModel = new Rewards();
    }

    public function index()
    {
        $userId = (int) $_SESSION['user']['id'];
        try {
            $history = $this->rewardModel->getUserRedemptionHistory($userId);
        } catch (PDOException $e) {
            error_log("Database error in reward history: " . $e->getMessage());
            $_SESSION['error'] = "Gagal memuat riwayat. Silakan coba beberapa saat lagi.";
            header("Location: ?page=user_rewards");
            exit;
        }

        include __DIR__ . '/../views/user/rewards/history.php';
    }
}