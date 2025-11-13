<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();

$id = $_GET['id'];

// ambil data produk utama
$stmt = $db->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    // Jika produk tidak ditemukan, tampilkan pesan dan keluar
    echo "<!doctype html><html lang='id'><head><meta charset='utf-8'><title>Produk Tidak Ditemukan</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body><div class='container py-5'><h3>Produk tidak ditemukan</h3><a href='javascript:history.back()' class='btn btn-secondary'>Kembali</a></div></body></html>";
    exit;
}

// ambil semua gambar
$imgs = $db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_main DESC, created_at ASC");
$imgs->execute([$id]);
$images = $imgs->fetchAll();

// ambil ulasan
$reviews = $db->prepare("
    SELECT r.*, u.name AS user_name 
    FROM product_reviews r 
    LEFT JOIN users u ON r.user_id = u.id 
    WHERE r.product_id = ? ORDER BY r.created_at DESC
");
$reviews->execute([$id]);
$reviews = $reviews->fetchAll();

// hitung rata-rata rating
$avgStmt = $db->prepare("SELECT ROUND(AVG(rating),1) AS avg_rating, COUNT(*) AS total_reviews FROM product_reviews WHERE product_id = ?");
$avgStmt->execute([$id]);
$ratingData = $avgStmt->fetch();

?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Detail Produk: <?= htmlspecialchars($product['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="javascript:history.back()" class="btn btn-secondary mb-3">← Kembali</a>

        <div class="row">
            <div class="col-md-6">
                <?php if (!empty($images)): ?>
                    <div class="mb-3">
                        <img src="uploads/<?= htmlspecialchars($images[0]['image_path']) ?>"
                            class="img-fluid rounded shadow" alt="Produk">
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($images as $img): ?>
                            <img src="uploads/<?= htmlspecialchars($img['image_path']) ?>" width="80" height="80"
                                class="rounded border" style="object-fit:cover;">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <img src="https://via.placeholder.com/500x400?text=No+Image" class="img-fluid rounded">
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p class="text-muted">Kategori: <span
                        class="badge bg-info text-dark"><?= htmlspecialchars($product['category_name']) ?></span></p>

                <?php
                $finalPrice = $product['price'] * (1 - $product['discount'] / 100);
                ?>
                <h4 class="text-danger">Rp <?= number_format($finalPrice, 0, ',', '.') ?></h4>
                <?php if ($product['discount'] > 0): ?>
                    <small class="text-muted"><del>Rp <?= number_format($product['price'], 0, ',', '.') ?></del> (Diskon
                        <?= $product['discount'] ?>%)</small>
                <?php endif; ?>

                <p class="mt-3"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <p><strong>Stok:</strong>
                    <?= $product['stock'] > 0 ? "<span class='text-success'>" . $product['stock'] . ' tersedia</span>' : "<span class='text-danger'>Habis</span>" ?>
                </p>

                <form method="post" action="?page=add_to_cart">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <div class="input-group mb-3" style="max-width:200px;">
                        <input type="number" name="quantity" class="form-control" value="1" min="1"
                            max="<?= $product['stock'] ?>" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                        <button class="btn btn-primary" type="submit" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>🛒
                            Tambah ke Keranjang</button>
                    </div>
                </form>
            </div>
        </div>


        <hr class="my-4">

        <h5>⭐ Ulasan Pengguna</h5>

        <?php if ($ratingData['total_reviews'] > 0): ?>
            <p>Rata-rata rating: <strong><?= $ratingData['avg_rating'] ?>/5</strong> dari
                <?= $ratingData['total_reviews'] ?> ulasan
            </p>
        <?php else: ?>
            <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
        <?php endif; ?>

        <?php foreach ($reviews as $r): ?>
            <div class="border rounded p-2 mb-2">
                <strong><?= htmlspecialchars($r['user_name']) ?></strong>
                <span class="text-warning"><?= str_repeat("★", $r['rating']) ?></span>
                <p><?= nl2br(htmlspecialchars($r['review'])) ?></p>
                <small class="text-muted"><?= date('d M Y', strtotime($r['created_at'])) ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>