<?php // app/views/promotions/list.php ?>
<!-- <!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Promo Aktif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Promo Aktif</h3>
        <?php if (empty($promos)): ?>
            <p>Tidak ada promo aktif.</p><?php else: ?>
            <div class="row">
                <?php foreach ($promos as $p): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($p['name']) ?></h5>
                                <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                                <p><b>Diskon:</b> <?= $p['discount'] ?>%</p>
                                <p><small>Periode: <?= $p['start_date'] ?> — <?= $p['end_date'] ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html> -->