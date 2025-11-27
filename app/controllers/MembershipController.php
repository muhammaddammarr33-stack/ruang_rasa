<?php
// require_once __DIR__ . '/../models/Memberships.php';
// require_once __DIR__ . '/../models/Rewards.php';

// class MembershipController
// {
//     private $m, $r;
//     public function __construct()
//     {
//         $this->m = new Memberships();
//         $this->r = new Rewards();
//         if (session_status() === PHP_SESSION_NONE)
//             session_start();
//     }

//     public function dashboard()
//     {
//         $userId = $_SESSION['user']['id'];
//         $membership = $this->m->createIfNotExist($userId);
//         $rewards = $this->r->all();
//         include __DIR__ . '/../views/membership/dashboard.php';
//     }

//     public function redeem()
//     {
//         $userId = $_SESSION['user']['id'];
//         $rewardId = $_POST['reward_id'];
//         try {
//             $this->r->redeem($userId, $rewardId);
//             $_SESSION['success'] = "Reward berhasil ditukarkan.";
//         } catch (Exception $e) {
//             $_SESSION['error'] = $e->getMessage();
//         }
//         header("Location: ?page=membership_dashboard");
//     }
// }
