<?php
require_once __DIR__ . '/DB.php';

class ConsultationSuggestion
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($consultationId, $productId, $reason)
    {
        $sql = "INSERT INTO consultation_suggestions (consultation_id, product_id, reason, created_at)
                VALUES (?, ?, ?, NOW())";
        return $this->db->prepare($sql)->execute([$consultationId, $productId, $reason]);
    }

    public function getByConsultation($id)
    {
        $sql = "
            SELECT cs.*, p.name AS product_name, p.price
            FROM consultation_suggestions cs
            JOIN products p ON p.id = cs.product_id
            WHERE cs.consultation_id=?
        ";
        $q = $this->db->prepare($sql);
        $q->execute([$id]);
        return $q->fetchAll();
    }

    public function autoSuggest($consultationId, $budget, $preference)
    {
        // Ambil seluruh produk
        $stmt = $this->db->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $preference = strtolower($preference);
        $keywords = explode(' ', $preference);

        $scored = [];

        foreach ($products as $p) {

            $score = 0;

            // 1. Score based on budget match
            if ($p['price'] <= $budget) {
                $score += 50;
            } else {
                // diskon kalau terlalu mahal
                $score -= 20;
            }

            // 2. Score based on keyword relevance
            foreach ($keywords as $word) {
                if (stripos($p['name'], $word) !== false)
                    $score += 20;
                if (stripos($p['description'], $word) !== false)
                    $score += 10;
            }

            // 3. Bonus kategori (jika ada)
            if (!empty($p['category_id'])) {
                if (stripos($preference, 'bunga') !== false && $p['category_id'] == 1)
                    $score += 25;
                if (stripos($preference, 'cokelat') !== false && $p['category_id'] == 2)
                    $score += 25;
            }

            $p['score'] = $score;
            $scored[] = $p;
        }

        // Urutkan berdasarkan score tertinggi
        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);

        // Ambil top 3
        $top3 = array_slice($scored, 0, 3);

        // Simpan ke consultation_suggestions
        foreach ($top3 as $p) {
            $stmt = $this->db->prepare("
            INSERT INTO consultation_suggestions (consultation_id, product_id, reason, created_at)
            VALUES (?, ?, ?, NOW())
        ");
            $reason = "Produk cocok dengan budget dan preferensi Anda.";
            $stmt->execute([$consultationId, $p['id'], $reason]);
        }

        return $top3;
    }
}
