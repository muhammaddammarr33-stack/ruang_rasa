<?php // app/views/checkout/form.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    $_SESSION['error'] = "Keranjang kosong.";
    header('Location: ?page=cart');
    exit;
}

// compute totals
$total = 0;
foreach ($cart as $item) {
    $price = $item['price'];
    $discount = isset($item['discount']) ? (float) $item['discount'] : 0;
    $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
    $total += $finalPrice * $item['qty'];
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Checkout</h3>

        <div class="row">
            <div class="col-md-7">
                <form method="post" action="?page=checkout_process">
                    <div class="mb-3">
                        <label>Nama Penerima</label>
                        <input type="text" name="recipient_name" class="form-control" required
                            value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label>Alamat Pengiriman</label>
                        <textarea name="shipping_address" class="form-control" rows="3"
                            required><?= htmlspecialchars($_POST['shipping_address'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Kurir</label>
                        <select name="courier" class="form-select" required>
                            <option value="jne">JNE</option>
                            <option value="tiki">TIKI</option>
                            <option value="pos">POS</option>
                            <option value="gojek">GO-SEND</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Metode Pembayaran</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="payment_method" value="cod" id="pm1" class="form-check-input"
                                checked>
                            <label class="form-check-label" for="pm1">Bayar di Tempat (COD)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="payment_method" value="transfer" id="pm2"
                                class="form-check-input">
                            <label class="form-check-label" for="pm2">Transfer Bank</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="payment_method" value="ewallet" id="pm3" class="form-check-input">
                            <label class="form-check-label" for="pm3">E-Wallet</label>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Bayar & Buat Pesanan — Rp
                        <?= number_format($total, 0, ',', '.') ?></button>
                </form>
            </div>

            <div class="col-md-5">
                <div class="card p-3">
                    <h5>Ringkasan Pesanan</h5>
                    <ul class="list-group mb-2">
                        <?php foreach ($cart as $it):
                            $price = $it['price'];
                            $discount = $it['discount'] ?? 0;
                            $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($it['name']) ?></div>
                                    <small class="text-muted">Qty: <?= $it['qty'] ?></small>
                                    <?php if (!empty($it['custom_text'])): ?>
                                        <div class="small">Teks: <?= htmlspecialchars($it['custom_text']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div>Rp <?= number_format($finalPrice * $it['qty'], 0, ',', '.') ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="d-flex justify-content-between">
                        <div>Total</div>
                        <div class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>