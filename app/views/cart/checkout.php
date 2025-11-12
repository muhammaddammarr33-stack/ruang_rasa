<?php // app/views/cart/checkout.php ?>
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
        <form method="post" action="?page=checkout">
            <div class="mb-3">
                <label>Alamat Pengiriman</label>
                <textarea name="shipping_address" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Metode Pembayaran</label>
                <select name="payment_method" class="form-select" required>
                    <option value="transfer">Transfer</option>
                    <option value="ewallet">E-Wallet</option>
                    <option value="cod">COD</option>
                    <option value="gateway">Gateway</option>
                </select>
            </div>
            <a href="?page=cart" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-success">Buat Pesanan</button>
        </form>
    </div>
</body>

</html>