<?php
require_once __DIR__ . '/../../models/DB.php';
$user = $_SESSION['user'];
$db = DB::getInstance();

// Ambil total order & total spent
$stmt = $db->prepare("SELECT COUNT(*) AS total_orders, SUM(total_amount) AS total_spent FROM orders WHERE user_id = ?");
$stmt->execute([$user['id']]);
$summary = $stmt->fetch();

// Ambil 5 pesanan terakhir
$stmt2 = $db->prepare("SELECT id, total_amount, payment_status, order_status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt2->execute([$user['id']]);
$orders = $stmt2->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dashboard Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Selamat datang, <?= htmlspecialchars($user['name']) ?>!</h3>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h5>Total Pesanan</h5>
                    <p class="fs-3"><?= $summary['total_orders'] ?? 0 ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h5>Total Belanja</h5>
                    <p class="fs-3">Rp <?= number_format($summary['total_spent'] ?? 0, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>

        <h4 class="mt-5">Pesanan Terbaru</h4>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= $o['id'] ?></td>
                        <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                        <td><?= ucfirst($o['payment_status']) ?></td>
                        <td><?= ucfirst($o['order_status']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
                        <td><a href="?page=user_orders&id=<?= $o['id'] ?>">#<?= $o['id'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?page=landing" class="btn btn-secondary mt-3">Kembali</a>
        <a href="?page=logout" class="btn btn-outline-danger mt-3">Logout</a>
    </div>
</body>

</html>