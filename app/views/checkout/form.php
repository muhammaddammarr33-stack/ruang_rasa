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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --off-white: #F5F5EC;
            --soft-blue: #79A1BF;
            --soft-peach: #E7A494;
            --dark-grey: #343D46;
        }

        body {
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
        }

        .checkout-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkout-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .form-check-input:checked {
            background-color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-checkout {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            box-shadow: 0 4px 12px rgba(121, 161, 191, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(121, 161, 191, 0.4);
        }

        .summary-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            height: fit-content;
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: var(--dark-grey);
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: var(--dark-grey);
        }

        .item-detail {
            font-size: 0.85rem;
            color: #777;
            margin-top: 0.25rem;
        }

        .total-row {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--soft-blue);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid var(--off-white);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--soft-blue);
            text-decoration: none;
        }

        @media (max-width: 768px) {

            .checkout-card,
            .summary-card {
                padding: 1.5rem;
            }

            .btn-checkout {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=landing">Beranda</a></li>
                <li class="breadcrumb-item"><a href="?page=cart">Keranjang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <h1 class="checkout-header">
            <i class="fas fa-receipt"></i> Konfirmasi Pesanan
        </h1>

        <div class="row g-4">
            <!-- Form Checkout -->
            <div class="col-md-7">
                <div class="checkout-card">
                    <form method="post" action="?page=checkout_process">
                        <div class="mb-4">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control" required
                                placeholder="Siapa yang akan menerima hadiah ini?"
                                value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Alamat Pengiriman Lengkap</label>
                            <textarea name="shipping_address" class="form-control" rows="4" required
                                placeholder="Contoh: Jl. Mawar No. 10, Kel. Sukajadi, Bandung"><?= htmlspecialchars($_POST['shipping_address'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kurir Pengiriman</label>
                            <select name="courier" class="form-select" required>
                                <option value="">-- Pilih Kurir --</option>
                                <option value="jne">JNE (1-2 hari)</option>
                                <option value="tiki">TIKI (2-3 hari)</option>
                                <option value="pos">POS Indonesia (3-5 hari)</option>
                                <option value="gojek">GO-SEND (Hari ini)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="cod" id="pm1"
                                        class="form-check-input" checked>
                                    <label class="form-check-label" for="pm1">
                                        <i class="fas fa-truck me-2"></i> Bayar di Tempat (COD)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="transfer" id="pm2"
                                        class="form-check-input">
                                    <label class="form-check-label" for="pm2">
                                        <i class="fas fa-university me-2"></i> Transfer Bank (BCA, BNI, Mandiri)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="ewallet" id="pm3"
                                        class="form-check-input">
                                    <label class="form-check-label" for="pm3">
                                        <i class="fas fa-wallet me-2"></i> E-Wallet (GoPay, OVO, DANA)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-checkout">
                            <i class="fas fa-check-circle me-2"></i>
                            Bayar & Kirim Kejutan — Rp <?= number_format($total, 0, ',', '.') ?>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-md-5">
                <div class="summary-card">
                    <h5 class="summary-title">Ringkasan Pesanan</h5>
                    <ul class="list-group">
                        <?php foreach ($cart as $it):
                            $price = $it['price'];
                            $discount = $it['discount'] ?? 0;
                            $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
                            ?>
                            <li class="list-group-item">
                                <div>
                                    <div class="item-name"><?= htmlspecialchars($it['name']) ?></div>
                                    <small class="text-muted">Qty: <?= $it['qty'] ?></small>
                                    <?php if (!empty($it['custom_text'])): ?>
                                        <div class="item-detail">Teks: "<?= htmlspecialchars($it['custom_text']) ?>"</div>
                                    <?php endif; ?>
                                </div>
                                <div class="fw-bold">Rp <?= number_format($finalPrice * $it['qty'], 0, ',', '.') ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="total-row d-flex justify-content-between">
                        <span>Total Pembayaran</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>