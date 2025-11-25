<?php
// app/controllers/RewardController.php
require_once __DIR__ . '/../models/Rewards.php';
require_once __DIR__ . '/../models/Memberships.php';

class RewardController
{
    private $rewardModel;
    private $membership;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $this->rewardModel = new Rewards();
        $this->membership = new Memberships();
    }

    // show catalog
    public function catalog()
    {
        $rewards = $this->rewardModel->all();
        include __DIR__ . '/../views/user/rewards.php';
    }

    // claim / redeem
    public function claim()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Silakan login untuk menukar reward.";
            header("Location: ?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $rewardId = (int) ($_GET['id'] ?? 0);
        if (!$rewardId) {
            $_SESSION['error'] = "Reward tidak ditemukan.";
            header("Location: ?page=user_rewards");
            exit;
        }

        $this->membership->ensureMembership($userId);
        $res = $this->membership->redeemReward($userId, $rewardId);

        if (!empty($res['error'])) {
            $_SESSION['error'] = $res['error'];
        } else {
            $_SESSION['success'] = "Reward berhasil diredeem. Cek halaman redeem untuk detail.";
        }

        header("Location: ?page=user_rewards");
        exit;
    }
    
}
