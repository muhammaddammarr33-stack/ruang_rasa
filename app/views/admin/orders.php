<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();

$orders = $db->query("
  SELECT o.id, u.name AS user_name, o.total_amount, o.payment_status, o.order_status, o.created_at
  FROM orders o
  LEFT JOIN users u ON o.user_id = u.id
  ORDER BY o.created_at DESC
")->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Daftar Pesanan</h3>
        <table class="table table-bordered mt-3 align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>#<?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['user_name']) ?></td>
                        <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                        <td><?= ucfirst($o['payment_status']) ?></td>
                        <td>
                            <form method="post" action="?page=admin_update_order_status" class="d-flex gap-2">
                                <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                <select name="order_status" class="form-select form-select-sm" required>
                                    <?php
                                    $statuses = ['waiting', 'processing', 'shipped', 'completed', 'cancelled'];
                                    foreach ($statuses as $s) {
                                        $sel = $s === $o['order_status'] ? 'selected' : '';
                                        echo "<option value='$s' $sel>" . ucfirst($s) . "</option>";
                                    }
                                    ?>
                                </select>
                                <button class="btn btn-sm btn-primary">Ubah</button>
                            </form>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
                        <td><a href="?page=admin_order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-primary">🔍
                                Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="?page=admin_dashboard" class="btn btn-secondary">Kembali</a>
    </div>
</body>

</html>