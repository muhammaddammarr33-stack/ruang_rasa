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

    public function autoSuggest($consultationId, $consultationData)
    {
        // Ekstrak data
        $budgetRange = $consultationData['budget_range'] ?? '';
        $interests = json_decode($consultationData['interests'] ?? '[]', true) ?: [];
        $occasion = $consultationData['occasion'] ?? '';
        $recipient = $consultationData['recipient'] ?? '';
        $ageRange = $consultationData['age_range'] ?? '';

        // 1. Konversi budget ke angka
        $budgetMap = [
            '<100rb' => [0, 100000],
            '100-300rb' => [100000, 300000],
            '300-500rb' => [300000, 500000],
            '>500rb' => [500000, 999999999],
        ];
        [$minBudget, $maxBudget] = $budgetMap[$budgetRange] ?? [0, 999999999];

        // 2. Mapping acara ke kategori
        $occasionToCategory = [
            'Ulang Tahun' => [1],
            'Lebaran' => [2],
            'Natal' => [3],
            'Valentine' => [4],
            'Hari Ibu' => [5],
            'Hari Ayah' => [5],
            'Kelulusan' => [6],
            'Pernikahan' => [7],
            'Kelahiran' => [8],
            'Corporate' => [9],
            'Imlek' => [10],
            'Tanpa Acara' => []
        ];

        $categories = $occasionToCategory[$occasion] ?? [];

        // 3. Mapping minat ke kategori
        $interestToCategory = [
            'Teknologi' => [11],
            'Fashion' => [12],
            'Memasak' => [13],
            'Olahraga' => [14],
            'Membaca' => [15],
            'Seni' => [16],
            'Musik' => [17],
            'Travel' => [18],
            'Game' => [19],
            'Kecantikan' => [20],
        ];

        foreach ($interests as $interest) {
            if (isset($interestToCategory[$interest])) {
                $categories = array_merge($categories, $interestToCategory[$interest]);
            }
        }

        // 4. Tambahkan kategori berdasarkan penerima
        $recipientToCategory = [
            'Pasangan' => [25],
            'Orang Tua' => [5],
            'Anak' => [23],
            'Teman' => [24],
            'Rekan Kerja' => [9],
            'Diri Sendiri' => [21, 22] // default wanita & pria
        ];

        if (isset($recipientToCategory[$recipient])) {
            $categories = array_merge($categories, $recipientToCategory[$recipient]);
        }

        // 5. Tambahkan kategori berdasarkan usia
        if ($ageRange === '<12') {
            $categories[] = 23; // Untuk Anak-anak
        } elseif ($ageRange === '13-17') {
            $categories[] = 24; // Untuk Remaja
        } elseif ($ageRange === '18-25') {
            // Tambahkan berdasarkan gender jika diketahui, default remaja
            $categories[] = 24;
        } elseif ($ageRange === '26-40') {
            // Dewasa muda - bisa semua
        } elseif ($ageRange === '>40') {
            // Prioritaskan kategori universal
        }

        // Hapus duplikat
        $categories = array_unique($categories);

        // 6. Bangun query
        $sql = "SELECT * FROM products WHERE price BETWEEN ? AND ?";
        $params = [$minBudget, $maxBudget];

        if (!empty($categories)) {
            $placeholders = str_repeat('?,', count($categories) - 1) . '?';
            $sql .= " AND category_id IN ($placeholders)";
            $params = array_merge($params, $categories);
        }

        // Ambil produk
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fallback: jika tidak ada yang cocok, ambil di budget saja
        if (empty($products)) {
            $stmt = $this->db->prepare("
            SELECT * FROM products 
            WHERE price BETWEEN ? AND ? 
            ORDER BY featured DESC, stock DESC
            LIMIT 5
        ");
            $stmt->execute([$minBudget, $maxBudget]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Urutkan berdasarkan featured & stok
        usort($products, function ($a, $b) {
            if ($a['featured'] != $b['featured']) {
                return $b['featured'] - $a['featured'];
            }
            return $b['stock'] - $a['stock'];
        });

        $top3 = array_slice($products, 0, 3);

        // Simpan ke database
        foreach ($top3 as $p) {
            $reason = "Direkomendasikan untuk ";
            $reason .= $recipient ? "'{$recipient}'" : "penerima";
            $reason .= $occasion && $occasion !== 'Tanpa Acara' ? " pada acara '{$occasion}'" : "";
            $reason .= " dengan budget {$budgetRange}.";

            $stmt = $this->db->prepare("
            INSERT INTO consultation_suggestions (consultation_id, product_id, reason, created_at)
            VALUES (?, ?, ?, NOW())
        ");
            $stmt->execute([$consultationId, $p['id'], $reason]);
        }

        return $top3;
    }
}
