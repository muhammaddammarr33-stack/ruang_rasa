<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();
$data = $db->query("
  SELECT c.*, u.name AS customer_name
  FROM consultations c
  LEFT JOIN users u ON c.user_id = u.id
  ORDER BY c.created_at DESC
")->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Daftar Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>📋 Daftar Konsultasi Pengguna</h3>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Topik</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['customer_name']) ?></td>
                        <td><?= htmlspecialchars($c['topic']) ?></td>
                        <td>Rp <?= number_format($c['budget'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $badge = [
                                'submitted' => 'secondary',
                                'suggested' => 'info',
                                'redirected' => 'warning',
                                'completed' => 'success'
                            ][$c['status']] ?? 'light';
                            ?>
                            <span class="badge bg-<?= $badge ?>"><?= ucfirst($c['status']) ?></span>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($c['created_at'])) ?></td>
                        <td>
                            <?php if ($c['status'] === 'submitted' || $c['status'] === 'redirected'): ?>
                                <a href="?page=consultation_suggest&id=<?= $c['id'] ?>" class="btn btn-sm btn-success">
                                    💡 Beri Rekomendasi
                                </a>
                            <?php else: ?>
                                <a href="?page=admin_consultation_detail&id=<?= $c['id'] ?>"
                                    class="btn btn-sm btn-outline-primary">
                                    👁️ Detail
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="?page=admin_dashboard" class="btn btn-secondary mt-3">⬅️ Kembali</a>
    </div>
</body>

</html>