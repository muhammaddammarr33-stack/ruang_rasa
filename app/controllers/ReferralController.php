<?php
// require_once __DIR__ . '/../models/Referrals.php';
// class ReferralController
// {
//     private $r;
//     public function __construct()
//     {
//         $this->r = new Referrals();
//         if (session_status() === PHP_SESSION_NONE)
//             session_start();
//     }

//     public function submit()
//     {
//         $referrer = $_SESSION['user']['id'];
//         $email = $_POST['referred_email'];
//         $this->r->create($referrer, $email, 50); // reward points proposal
//         $_SESSION['success'] = "Referral tersimpan.";
//         header("Location: ?page=membership_dashboard");
//     }
// }
