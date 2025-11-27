<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Promo Spesial - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h3 class="text-center mb-4">🎉 Promo Spesial Hari Ini</h3>

        <?php if (empty($promos)): ?>
            <p class="text-center text-muted">Belum ada promo aktif saat ini.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($promos as $p): ?>
                    <?php
                    $finalPrice = $p['price'] - ($p['price'] * $p['discount'] / 100);
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="public/uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png') ?>"
                                class="card-img-top">
                            <div class="card-body">
                                <h6><?= htmlspecialchars($p['name']) ?></h6>
                                <p class="text-muted small mb-1"><?= htmlspecialchars($p['category_name'] ?? '-') ?></p>
                                <span class="badge bg-danger mb-2">Diskon <?= $p['discount'] ?>%</span><br>
                                <span class="text-decoration-line-through text-muted">Rp
                                    <?= number_format($p['price'], 0, ',', '.') ?></span><br>
                                <strong class="text-primary fs-6">Rp <?= number_format($finalPrice, 0, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>