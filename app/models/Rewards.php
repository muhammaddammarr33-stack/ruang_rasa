<?php
// // app/models/Rewards.php
// require_once __DIR__ . '/DB.php';

// class Rewards
// {
//     private $db;
//     public function __construct()
//     {
//         $this->db = DB::getInstance();
//     }

//     public function all()
//     {
//         return $this->db->query("SELECT * FROM rewards ORDER BY points_required ASC")->fetchAll();
//     }

//     public function find($id)
//     {
//         $stmt = $this->db->prepare("SELECT * FROM rewards WHERE id=?");
//         $stmt->execute([$id]);
//         return $stmt->fetch();
//     }

//     public function redeem($userId, $rewardId)
//     {
//         $reward = $this->find($rewardId);
//         if (!$reward)
//             throw new Exception("Reward tidak ditemukan");

//         // cek membership points
//         $mStmt = $this->db->prepare("SELECT points FROM memberships WHERE user_id = ?");
//         $mStmt->execute([$userId]);
//         $points = $mStmt->fetchColumn();
//         if ($points === false)
//             $points = 0;
//         if ($points < $reward['points_required'])
//             throw new Exception("Poin tidak cukup");

//         // kurangi poin
//         $this->db->beginTransaction();
//         try {
//             // deduct
//             $this->db->prepare("UPDATE memberships SET points = points - ?, updated_at = NOW() WHERE user_id = ?")
//                 ->execute([$reward['points_required'], $userId]);

//             // log redemption
//             $this->db->prepare("INSERT INTO reward_redemptions (user_id, reward_id, redeemed_at) VALUES (?, ?, NOW())")
//                 ->execute([$userId, $rewardId]);

//             $this->db->commit();
//         } catch (Exception $e) {
//             $this->db->rollBack();
//             throw $e;
//         }
//     }
// }
