<?php
// // app/models/Referrals.php
// require_once __DIR__ . '/DB.php';

// class Referrals
// {
//     private $db;
//     public function __construct()
//     {
//         $this->db = DB::getInstance();
//     }

//     public function create($referrerId, $referredEmail, $points = 0)
//     {
//         $stmt = $this->db->prepare("INSERT INTO referrals (referrer_id, referred_email, reward_points, status) VALUES (?, ?, ?, 'pending')");
//         $stmt->execute([$referrerId, $referredEmail, $points]);
//         return $this->db->lastInsertId();
//     }

//     public function markCompleted($id)
//     {
//         $this->db->prepare("UPDATE referrals SET status = 'completed' WHERE id = ?")->execute([$id]);
//     }
// }
