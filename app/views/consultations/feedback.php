<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();

$id = $_GET['id'];

// ambil rekomendasi produk
$stmt = $db->prepare("
  SELECT cs.*, p.name AS product_name, p.price
  FROM consultation_suggestions cs
  LEFT JOIN products p ON cs.product_id = p.id
  WHERE cs.consultation_id = ?
");
$stmt->execute([$id]);
$suggestions = $stmt->fetchAll();

// ambil data konsultasi (biar bisa tampil topik & budget)
$cons = $db->prepare("SELECT topic, budget FROM consultations WHERE id = ?");
$cons->execute([$id]);
$consultation = $cons->fetch();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container py-4">
    <h3 class="mb-3">💬 Feedback Konsultasi</h3>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-1">Topik: <?= htmlspecialchars($consultation['topic']) ?></h5>
            <p class="card-text mb-0">Budget: <strong>Rp
                    <?= number_format($consultation['budget'], 0, ',', '.') ?></strong></p>
        </div>
    </div>

    <h5>💡 Rekomendasi Produk dari Konsultan</h5>
    <?php if ($suggestions): ?>
        <div class="row mt-3">
            <?php foreach ($suggestions as $s): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($s['image'])): ?>
                            <img src="public/uploads/<?= htmlspecialchars($s['image_path']) ?>" class="card-img-top"
                                style="height:200px; object-fit:cover;" alt="Produk">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" alt="No Image">
                        <?php endif; ?>

                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($s['product_name']) ?></h6>
                            <p class="text-muted mb-1">Rp <?= number_format($s['price'], 0, ',', '.') ?></p>
                            <p class="small"><?= htmlspecialchars($s['reason']) ?></p>
                        </div>

                        <div class="card-footer text-center">
                            <a href="?page=product_detail&id=<?= $s['product_id'] ?>" class="btn btn-outline-primary btn-sm">
                                🔍 Lihat Produk
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted mt-2">Belum ada rekomendasi dari admin atau konsultan.</p>
    <?php endif; ?>

    <hr>

    <h5>🗣️ Berikan Feedback Anda</h5>
    <form method="post" action="?page=consultation_feedback&id=<?= $_GET['id'] ?>">
        <div class="mb-3">
            <label>Apakah Anda puas dengan rekomendasi kami?</label><br>
            <label><input type="radio" name="satisfaction" value="satisfied" required> Puas</label><br>
            <label><input type="radio" name="satisfaction" value="unsatisfied" required> Tidak Puas</label>
        </div>
        <button class="btn btn-primary">Kirim Feedback</button>
    </form>
</div>
</body>

</html>