<?php
// // app/models/Promotions.php
// require_once __DIR__ . '/DB.php';

// class Promotions {
//     private $db;
//     public function __construct(){ $this->db = DB::getInstance(); }

//     public function getActivePromotions($date = null){
//         $date = $date ?? date('Y-m-d');
//         $stmt = $this->db->prepare("SELECT * FROM promotions WHERE start_date <= ? AND end_date >= ?");
//         $stmt->execute([$date, $date]); return $stmt->fetchAll();
//     }

//     public function getProductPromotions($productId){
//         $stmt = $this->db->prepare("
//             SELECT pr.*
//             FROM promotions pr
//             JOIN product_promotions pp ON pp.promotion_id = pr.id
//             WHERE pp.product_id = ? AND pr.start_date <= CURDATE() AND pr.end_date >= CURDATE()
//         ");
//         $stmt->execute([$productId]); return $stmt->fetchAll();
//     }

//     public function getBestDiscountForProduct($productId){
//         $promos = $this->getProductPromotions($productId);
//         $best = 0.0;
//         foreach ($promos as $p) if ((float)$p['discount'] > $best) $best = (float)$p['discount'];
//         return $best; // percentage value e.g. 10.00
//     }

//     // admin helpers omitted for brevity (create/update/delete)
// }
