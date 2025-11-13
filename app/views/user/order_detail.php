<!-- app/views/user/order_detail.php -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h3 class="mb-4">📦 Detail Pesanan #<?= $order['id'] ?></h3>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Status Pesanan:</strong>
                    <span class="badge bg-<?= $order['order_status'] === 'completed' ? 'success' : 'info' ?>">
                        <?= ucfirst($order['order_status']) ?>
                    </span>
                </p>
                <p><strong>Metode Pembayaran:</strong> <?= ucfirst($order['payment_method']) ?></p>
                <p><strong>Alamat Pengiriman:</strong><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
            </div>
        </div>

        <h5>🛒 Produk yang Dipesan</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($items as $it): ?>
                    <?php $total += $it['subtotal']; ?>
                    <tr>
                        <td><?= htmlspecialchars($it['product_name']) ?></td>
                        <td>Rp <?= number_format($it['price'], 0, ',', '.') ?></td>
                        <td><?= $it['quantity'] ?></td>
                        <td>Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="text-end mt-3">
            <a href="?page=orders" class="btn btn-secondary">⬅ Kembali</a>
        </div>
    </div>
</body>

</html>