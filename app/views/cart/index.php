<?php // app/views/cart/index.php
// expects $cart = $_SESSION['cart']
if (session_status() === PHP_SESSION_NONE)
    session_start();
$cart = $_SESSION['cart'] ?? [];
?>
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
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="alert alert-light">Keranjang kosong. <a href="?page=landing">Lanjut belanja</a></div>
        <?php else: ?>
            <form method="post" action="?page=cart_update"> <!-- optional untuk update qty -->
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
                        <?php $total = 0;
                        foreach ($cart as $index => $item):
                            $price = $item['price'];
                            $discount = isset($item['discount']) ? (float) $item['discount'] : 0;
                            $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
                            $subtotal = $finalPrice * $item['qty'];
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($item['name']) ?>
                                    <?php if (!empty($item['custom_text'])): ?>
                                        <div class="small text-muted">Teks: <?= htmlspecialchars($item['custom_text']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($discount > 0): ?>
                                        <div class="text-muted small text-decoration-line-through">Rp
                                            <?= number_format($price, 0, ',', '.') ?></div>
                                        <div class="fw-bold">Rp <?= number_format($finalPrice, 0, ',', '.') ?> <span
                                                class="badge bg-danger">-<?= $discount ?>%</span></div>
                                    <?php else: ?>
                                        <div class="fw-bold">Rp <?= number_format($price, 0, ',', '.') ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <input type="number" name="qty[<?= $index ?>]" value="<?= $item['qty'] ?>" min="1"
                                        class="form-control form-control-sm" style="width:80px;">
                                </td>
                                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                <td>
                                    <?php if (empty($item['custom_id'])): ?>
                                        <a href="?page=custom_form&cart_index=<?= urlencode($index) ?>"
                                            class="btn btn-sm btn-warning">🎨 Personalisasi</a>
                                    <?php else: ?>
                                        <span class="badge bg-success">✅ Dipersonalisasi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?page=remove_from_cart&id=<?= urlencode($index) ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus item ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" formaction="?page=cart_update" class="btn btn-secondary btn-sm">Update
                            Qty</button>
                        <a href="?page=landing" class="btn btn-outline-secondary btn-sm">Lanjut Belanja</a>
                    </div>

                    <div class="text-end">
                        <h5>Total: Rp <?= number_format($total, 0, ',', '.') ?></h5>
                        <a href="?page=checkout" class="btn btn-primary">Lanjut ke Checkout</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>