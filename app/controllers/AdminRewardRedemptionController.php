<?php
require_once __DIR__ . '/../models/Rewards.php';

class AdminRewardRedemptionController
{
    private $rewardModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $this->rewardModel = new Rewards();
    }

    public function index()
    {
        $history = $this->rewardModel->getAllRedemptionHistory();
        include __DIR__ . '/../views/admin/rewards/redemptions.php';
    }
}
