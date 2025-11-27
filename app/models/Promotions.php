<?php
// app/models/Promotions.php
require_once __DIR__ . '/DB.php';

class Promotions
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    // ✅ ambil semua promo
    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM promotions ORDER BY start_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ ambil promo by id
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM promotions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ create promo baru
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO promotions (name, type, discount, start_date, end_date, description)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],
            $data['type'],
            $data['discount'],
            $data['start_date'],
            $data['end_date'],
            $data['description']
        ]);
        return $this->db->lastInsertId();
    }

    // ✅ update promo
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE promotions SET name=?, type=?, discount=?, start_date=?, end_date=?, description=? WHERE id=?
        ");
        return $stmt->execute([
            $data['name'],
            $data['type'],
            $data['discount'],
            $data['start_date'],
            $data['end_date'],
            $data['description'],
            $id
        ]);
    }

    // ✅ hapus promo
    public function delete($id)
    {
        $this->db->prepare("DELETE FROM product_promotions WHERE promotion_id = ?")->execute([$id]);
        $stmt = $this->db->prepare("DELETE FROM promotions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ✅ ambil semua produk yg terhubung ke promo
    public function getProductsByPromo($promoId)
    {
        $stmt = $this->db->prepare("SELECT product_id FROM product_promotions WHERE promotion_id = ?");
        $stmt->execute([$promoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ simpan ulang relasi produk
    public function syncProducts($promoId, $productIds)
    {
        // hapus dulu
        $this->db->prepare("DELETE FROM product_promotions WHERE promotion_id = ?")->execute([$promoId]);

        // masukkan ulang
        if (!empty($productIds)) {
            $stmt = $this->db->prepare("INSERT INTO product_promotions (product_id, promotion_id) VALUES (?, ?)");
            foreach ($productIds as $pid) {
                $stmt->execute([$pid, $promoId]);
            }
        }
    }

    // ✅ ambil diskon terbaik untuk produk
    public function getBestDiscountForProduct($productId)
    {
        $stmt = $this->db->prepare("
            SELECT MAX(p.discount) AS discount
            FROM promotions p
            JOIN product_promotions pp ON p.id = pp.promotion_id
            WHERE pp.product_id = ?
              AND CURDATE() BETWEEN p.start_date AND p.end_date
        ");
        $stmt->execute([$productId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (float) $row['discount'] : 0;
    }
}
