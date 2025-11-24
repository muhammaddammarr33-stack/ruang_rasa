<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Feedback Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-4">

        <h3 class="mb-3">💬 Feedback Konsultasi</h3>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-1">Untuk: <?= htmlspecialchars($consultation['recipient']) ?></h5>
                <p class="card-text mb-1">Acara: <strong><?= htmlspecialchars($consultation['occasion']) ?></strong></p>
                <p class="card-text mb-1">Usia: <?= htmlspecialchars($consultation['age_range']) ?></p>
                <p class="card-text mb-1">Minat:
                    <?php
                    $interests = json_decode($consultation['interests'], true);
                    echo $interests ? implode(', ', $interests) : '-';
                    ?>
                </p>
                <p class="card-text mb-0">Anggaran:
                    <strong><?= htmlspecialchars($consultation['budget_range']) ?></strong></p>
            </div>
        </div>

        <h5>💡 Rekomendasi Produk</h5>
        <?php if ($suggestions): ?>
            <div class="row mt-3">
                <?php foreach ($suggestions as $s): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6><?= htmlspecialchars($s['product_name']) ?></h6>
                                <p class="text-muted"><?= number_format($s['price'], 0, ',', '.') ?></p>
                                <p><?= htmlspecialchars($s['reason']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Belum ada rekomendasi.</p>
        <?php endif; ?>

        <hr>

        <hr>

        <h5>🗣️ Apakah rekomendasi ini membantu?</h5>
        <form method="post" action="?page=consultation_feedback_submit&id=<?= $_GET['id'] ?>">
            <div class="mb-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="satisfaction" value="satisfied" id="sat"
                        required>
                    <label class="form-check-label" for="sat">✅ Ya, saya puas</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="satisfaction" value="unsatisfied" id="unsat"
                        required>
                    <label class="form-check-label" for="unsat">❌ Belum sesuai, saya butuh bantuan lebih lanjut</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Feedback</button>
        </form>

    </div>

</body>

</html>