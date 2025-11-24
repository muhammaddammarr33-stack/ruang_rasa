<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Detail Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-4">

        <h3>🧾 Detail Konsultasi #<?= $consultation['id'] ?></h3>

        <p><strong>Penerima:</strong> <?= htmlspecialchars($consultation['recipient']) ?></p>
        <p><strong>Acara:</strong> <?= htmlspecialchars($consultation['occasion']) ?></p>
        <p><strong>Usia:</strong> <?= htmlspecialchars($consultation['age_range']) ?></p>
        <p><strong>Minat:</strong>
            <?php
            $interests = json_decode($consultation['interests'], true);
            echo $interests ? implode(', ', $interests) : '-';
            ?>
        </p>
        <p><strong>Anggaran:</strong> <?= htmlspecialchars($consultation['budget_range']) ?></p>
        <p><strong>Status:</strong>
            <span class="badge bg-primary"><?= ucfirst($consultation['status']) ?></span>
        </p>

        <div class="mt-3">
            <a href="?page=admin_consultation_ai&id=<?= $consultation['id'] ?>" class="btn btn-sm btn-warning">🤖
                Generate AI Suggestion</a>

            <a href="?page=consultation_suggest&id=<?= $consultation['id'] ?>" class="btn btn-sm btn-success">➕ Manual
                Suggestion</a>

            <a href="?page=consultation_chat&id=<?= $consultation['id'] ?>" class="btn btn-sm btn-info">💬 Buka Chat</a>

            <?php if ($consultation['status'] !== 'completed'): ?>
                <a href="?page=admin_consultation_done&id=<?= $consultation['id'] ?>" class="btn btn-sm btn-secondary">✔
                    Tandai Selesai</a>
            <?php endif; ?>
        </div>

        <hr>

        <h5>💡 Rekomendasi Produk</h5>
        <?php if ($suggestions): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Alasan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suggestions as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['product_name']) ?></td>
                            <td>Rp <?= number_format($s['price'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($s['reason']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($s['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><em>Belum ada rekomendasi.</em></p>
        <?php endif; ?>

        <hr>

        <h5>🗣️ Feedback User</h5>
        <?php if ($feedback): ?>
            <p><strong>Kepuasan:</strong> <?= ucfirst($feedback['satisfaction']) ?></p>
            <p><strong>Follow Up:</strong> <?= $feedback['follow_up'] ? 'Ya' : 'Tidak' ?></p>
        <?php else: ?>
            <p><em>Belum ada feedback.</em></p>
        <?php endif; ?>

        <a href="?page=admin_consultations" class="btn btn-secondary mt-3">⬅ Kembali</a>
    </div>
</body>

</html>