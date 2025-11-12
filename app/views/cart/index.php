<?php // app/views/cart/index.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Keranjang Belanja</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <p>Keranjang kosong. <a href="?page=landing">Belanja sekarang</a></p>
        <?php else: ?>
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Personalisasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $index => $item): // ✅ tambahkan $index di sini!
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($item['name']) ?>
                                <?php if (isset($item['custom_text'])): ?>
                                    <br><small class="text-muted">Teks: <?= htmlspecialchars($item['custom_text']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            <td>
                                <?php if (!isset($item['custom_id'])): ?>
                                    <a href="?page=custom_form&cart_index=<?= $index ?>" class="btn btn-sm btn-warning">🎨
                                        Personalisasi</a>
                                <?php else: ?>
                                    <span class="badge bg-success">✅ Sudah Dipersonalisasi</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?page=remove_from_cart&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">🗑
                                    Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <h5>Total: Rp <?= number_format($total, 0, ',', '.') ?></h5>
                <div>
                    <a href="?page=landing" class="btn btn-secondary">⬅️ Kembali</a>
                    <a href="?page=checkout" class="btn btn-primary">Lanjut ke Checkout ➡️</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>