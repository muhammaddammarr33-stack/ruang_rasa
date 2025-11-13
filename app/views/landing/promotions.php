<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Promo Spesial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2 class="mb-4">🔥 Promo Spesial</h2>

        <?php if (empty($promos)): ?>
            <p class="text-muted">Belum ada promo aktif saat ini.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($promos as $p): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                                <p class="text-danger fw-bold">Diskon <?= $p['discount'] ?>%</p>
                                <p><small><?= htmlspecialchars($p['description']) ?></small></p>
                                <p class="text-muted small">Periode: <?= $p['start_date'] ?> → <?= $p['end_date'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="?page=landing" class="btn btn-secondary mt-3">⬅️ Kembali</a>
    </div>
</body>

</html>