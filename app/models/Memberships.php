<?php
// // app/models/Memberships.php
// require_once __DIR__ . '/DB.php';

// class Memberships
// {
//     private $db;
//     public function __construct()
//     {
//         $this->db = DB::getInstance();
//     }

//     public function getByUser($userId)
//     {
//         $stmt = $this->db->prepare("SELECT * FROM memberships WHERE user_id = ?");
//         $stmt->execute([$userId]);
//         return $stmt->fetch();
//     }

//     public function createIfNotExist($userId)
//     {
//         $m = $this->getByUser($userId);
//         if (!$m) {
//             $this->db->prepare("INSERT INTO memberships (user_id, tier, points, updated_at) VALUES (?, 'basic', 0, NOW())")
//                 ->execute([$userId]);
//             return $this->getByUser($userId);
//         }
//         return $m;
//     }

//     public function addPoints($userId, $points)
//     {
//         $this->createIfNotExist($userId);
//         $this->db->prepare("UPDATE memberships SET points = points + ?, updated_at = NOW() WHERE user_id = ?")
//             ->execute([$points, $userId]);
//         $this->updateTier($userId);
//     }

//     public function updateTier($userId)
//     {
//         $stmt = $this->db->prepare("SELECT points FROM memberships WHERE user_id = ?");
//         $stmt->execute([$userId]);
//         $total = (int) $stmt->fetchColumn();
//         $tier = 'basic';
//         if ($total >= 2000)
//             $tier = 'platinum';
//         elseif ($total >= 1000)
//             $tier = 'gold';
//         elseif ($total >= 500)
//             $tier = 'silver';
//         $this->db->prepare("UPDATE memberships SET tier = ?, updated_at = NOW() WHERE user_id = ?")
//             ->execute([$tier, $userId]);
//     }

//     public function getHistory($userId)
//     {
//         // if you also want a user_points log table, query that. For now use memberships row.
//         $stmt = $this->db->prepare("SELECT * FROM memberships WHERE user_id = ?");
//         $stmt->execute([$userId]);
//         return $stmt->fetchAll();
//     }
// }
