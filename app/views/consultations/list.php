<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Daftar Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-4">
        <h3>Daftar Konsultasi Anda</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Untuk</th>
                    <th>Acara</th>
                    <th>Anggaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['recipient']) ?></td>
                        <td><?= htmlspecialchars($c['occasion']) ?></td>
                        <td><?= htmlspecialchars($c['budget_range']) ?></td>
                        <td>
                            <?php
                            $statusLabels = [
                                'submitted' => 'Menunggu',
                                'suggested' => 'Rekomendasi Siap',
                                'in_progress' => 'Sedang Berlangsung',
                                'completed' => 'Selesai'
                            ];
                            echo $statusLabels[$c['status']] ?? ucfirst($c['status']);
                            ?>
                        </td>
                        <td>
                            <?php if ($c['status'] === 'suggested'): ?>
                                <a href="?page=consultation_feedback&id=<?= $c['id'] ?>"
                                    class="btn btn-sm btn-primary">Feedback</a>
                            <?php endif; ?>
                            <?php if ($c['status'] !== 'completed'): ?>
                                <a href="?page=consultation_chat&id=<?= $c['id'] ?>" class="btn btn-sm btn-info">💬 Chat</a>
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