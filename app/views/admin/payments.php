<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();
$payments = $db->query("
  SELECT p.*, o.user_id, u.name AS user_name
  FROM payments p
  LEFT JOIN orders o ON p.order_id = o.id
  LEFT JOIN users u ON o.user_id = u.id
  ORDER BY p.created_at DESC
")->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Daftar Pembayaran</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Gateway</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['user_name']) ?></td>
                        <td><?= htmlspecialchars($p['payment_gateway']) ?></td>
                        <td>Rp <?= number_format($p['amount'], 0, ',', '.') ?></td>
                        <td><?= ucfirst($p['status']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($p['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?page=admin_dashboard" class="btn btn-secondary">Kembali</a>
    </div>
</body>

</html>