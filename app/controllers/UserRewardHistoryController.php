<?php
require_once __DIR__ . '/../models/Rewards.php';

class UserRewardHistoryController
{
    private $rewardModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        // FIX BESAR → gunakan model Rewards, bukan controller
        $this->rewardModel = new Rewards();
    }

    public function index()
    {
        $userId = $_SESSION['user']['id'];
        $history = $this->rewardModel->getUserRedemptionHistory($userId);

        include __DIR__ . '/../views/user/rewards/history.php';
    }
}
