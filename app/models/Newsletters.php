<?php
// // app/models/Newsletters.php
// require_once __DIR__ . '/DB.php';

// class Newsletters
// {
//     private $db;
//     public function __construct()
//     {
//         $this->db = DB::getInstance();
//     }

//     public function subscribe($email)
//     {
//         $stmt = $this->db->prepare("INSERT INTO newsletters (email, subscribed_at) VALUES (?, NOW())");
//         $stmt->execute([$email]);
//     }

//     public function all()
//     {
//         return $this->db->query("SELECT * FROM newsletters ORDER BY subscribed_at DESC")->fetchAll();
//     }
// }
