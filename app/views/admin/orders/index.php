<?php // app/views/admin/orders/index.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Manajemen Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- app/views/admin/orders/index.php -->
    <div class="container py-5">
        <h3 class="mb-4">📦 Daftar Pesanan Pelanggan</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (!empty($orders)): ?>
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['user_name']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
                            <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-<?= $o['payment_status'] === 'paid' ? 'success' : 'warning' ?>">
                                    <?= ucfirst($o['payment_status']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= match ($o['order_status']) {
                                    'waiting' => 'secondary',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'secondary'
                                } ?>">
                                    <?= ucfirst($o['order_status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="?page=admin_order_detail&id=<?= $o['id'] ?>"
                                    class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">Belum ada pesanan.</div>
        <?php endif; ?>
    </div>
</body>

</html>