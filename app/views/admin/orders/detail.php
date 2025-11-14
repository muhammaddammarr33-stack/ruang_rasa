<?php // app/views/admin/orders/detail.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- app/views/admin/orders/detail.php -->
    <div class="container py-5">
        <h3 class="mb-4">📦 Detail Pesanan #<?= htmlspecialchars($order['id']) ?></h3>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Pemesan</h5>
                <p><strong>Nama:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['user_email']) ?></p>
                <p><strong>Alamat Pengiriman:</strong><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Daftar Produk</h5>
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($items as $item): ?>
                            <?php $total += $item['subtotal']; ?>
                            <tr>
                                <td style="width:100px;">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="public/uploads/<?= htmlspecialchars($item['image']) ?>"
                                            alt="<?= htmlspecialchars($item['product_name']) ?>" class="img-fluid rounded">
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php if (!empty($customOrders)): ?>
            <h5 class="mt-4">Personalisasi Terkait</h5>
            <?php foreach ($customOrders as $co): ?>
                <div class="border p-2 mb-2">
                    <strong><?= htmlspecialchars($co['product_name']) ?> (ID #<?= $co['id'] ?>)</strong><br>
                    Teks: <?= htmlspecialchars($co['custom_text']) ?><br>
                    Font: <?= htmlspecialchars($co['font_style']) ?><br>
                    Warna: <span
                        style="display:inline-block;width:18px;height:18px;background:<?= htmlspecialchars($co['text_color']) ?>;border:1px solid #ccc"></span>
                    <?= htmlspecialchars($co['text_color']) ?><br>
                    Packaging: <?= htmlspecialchars($co['packaging_type']) ?><br>
                    Ribbon: <?= htmlspecialchars($co['ribbon_color']) ?><br>
                    Catatan: <?= nl2br(htmlspecialchars($co['special_instructions'])) ?><br>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($payment)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Pembayaran</h5>
                    <p><strong>Metode:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?= $payment['status'] === 'success' ? 'success' : 'warning' ?>">
                            <?= ucfirst($payment['status']) ?>
                        </span>
                    </p>
                    <p><strong>Total Dibayar:</strong> Rp <?= number_format($payment['amount'], 0, ',', '.') ?></p>
                    <p><strong>Transaction ID:</strong> <?= htmlspecialchars($payment['transaction_id'] ?? '-') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($shipping)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Pengiriman</h5>
                    <p><strong>Kurir:</strong> <?= htmlspecialchars($shipping['courier']) ?></p>
                    <p><strong>No. Resi:</strong> <?= htmlspecialchars($shipping['tracking_number']) ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-<?= $shipping['status'] === 'delivered' ? 'success' : 'info' ?>">
                            <?= ucfirst($shipping['status']) ?>
                        </span>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <a href="?page=admin_orders" class="btn btn-secondary">⬅ Kembali ke daftar</a>
    </div>
</body>

</html>