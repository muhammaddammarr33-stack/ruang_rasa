<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>📋 Daftar Konsultasi</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Untuk</th> <!-- ganti dari "Topik" -->
                    <th>Anggaran</th> <!-- ganti dari "Budget" -->
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['user_name']) ?></td>
                        <td><?= htmlspecialchars($c['recipient'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($c['budget_range'] ?? '-') ?></td>
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
                        <td><?= date('d M Y H:i', strtotime($c['created_at'])) ?></td>
                        <td>
                            <?php if ($c['status'] === 'submitted'): ?>
                                <a href="?page=consultation_suggest&id=<?= $c['id'] ?>"
                                    class="btn btn-sm btn-success">Rekomendasi</a>
                            <?php else: ?>
                                <a href="?page=admin_consultation_detail&id=<?= $c['id'] ?>"
                                    class="btn btn-sm btn-outline-primary">Detail</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="?page=admin_dashboard" class="btn btn-secondary mt-3">⬅ Kembali</a>
    </div>
</body>

</html>