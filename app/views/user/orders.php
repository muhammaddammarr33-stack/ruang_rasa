<!-- app/views/user/orders.php -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Riwayat pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h3 class="mb-4">🛍️ Riwayat Pesanan Saya</h3>

        <?php if (!empty($orders)): ?>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Metode Pembayaran</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($o['id']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
                            <td>
                                <?php
                                $statusColor = [
                                    'waiting' => 'secondary',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $color = $statusColor[$o['order_status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $color ?>">
                                    <?= ucfirst($o['order_status']) ?>
                                </span>
                            </td>
                            <td><?= ucfirst($o['payment_method']) ?></td>
                            <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <a href="?page=order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Belum ada riwayat pesanan.
            </div>
        <?php endif; ?>
    </div>
</body>

</html>