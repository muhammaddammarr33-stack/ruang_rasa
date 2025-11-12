<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
    unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="container py-4">
    <h3>Daftar Konsultasi</h3>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Topik</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultations as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['topic']) ?></td>
                    <td>Rp <?= number_format($c['budget'], 0, ',', '.') ?></td>
                    <td><?= ucfirst($c['status']) ?></td>
                    <td>
                        <?php if ($c['status'] === 'suggested'): ?>
                            <a href="?page=consultation_feedback&id=<?= $c['id'] ?>" class="btn btn-sm btn-primary">Feedback</a>
                        <?php elseif ($c['status'] === 'completed'): ?>
                            <span class="text-success">Selesai</span>
                        <?php else: ?>
                            <span class="text-muted">Menunggu</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="?page=landing" class="btn btn-secondary">Kembali</a>
    <a href="?page=consultation_form" class="btn btn-success">+ Konsultasi Baru</a>
</div>
</body>

</html>