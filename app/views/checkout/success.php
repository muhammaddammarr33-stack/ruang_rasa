<?php // app/views/checkout/success.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$orderId = $_GET['id'] ?? null;
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Terima kasih — Pesanan sudah dibuat!</h3>
        <?php if ($orderId): ?>
            <p>ID Pesanan: <strong>#<?= htmlspecialchars($orderId) ?></strong></p>
            <a href="?page=orders" class="btn btn-outline-primary">Lihat Riwayat Pesanan</a>
        <?php else: ?>
            <p class="text-muted">Pesanan berhasil diproses.</p>
            <a href="?page=landing" class="btn btn-secondary">Kembali ke Beranda</a>
        <?php endif; ?>
    </div>
</body>

</html>