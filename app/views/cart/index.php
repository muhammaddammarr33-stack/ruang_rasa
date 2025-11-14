<?php // app/views/cart/index.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja | Ruang Rasa</title>

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

        .cart-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 1.75rem;
            margin-bottom: 2rem;
        }

        .alert {
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: rgba(231, 164, 148, 0.2);
            border: none;
            color: var(--dark-grey);
        }

        .btn-primary {
            background-color: var(--soft-blue);
            border: none;
        }

        .btn-primary:hover {
            background-color: #658db2;
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: var(--dark-grey);
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        .btn-outline-secondary {
            color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-outline-secondary:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        .btn-warning {
            background-color: #fde047;
            color: #333;
            border: none;
        }

        .btn-danger {
            background-color: #fca5a5;
            color: #991b1b;
            border: none;
        }

        .form-control-sm {
            border-radius: 8px;
            padding: 0.35rem 0.5rem;
        }

        .personalization-detail {
            font-size: 0.85rem;
            background: rgba(121, 161, 191, 0.05);
            padding: 0.6rem;
            border-radius: 10px;
            margin-top: 0.5rem;
        }

        .total-section {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            padding: 1.25rem;
            border-radius: 16px;
            text-align: right;
        }

        .total-section h5 {
            margin-bottom: 0.75rem;
            font-weight: 700;
            font-size: 1.4rem;
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

        /* Responsif: tumpuk di mobile */
        @media (max-width: 768px) {
            .cart-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .cart-table thead {
                display: none;
            }

            .cart-table tbody tr {
                display: block;
                margin-bottom: 1.25rem;
                padding: 1rem;
                background: white;
                border-radius: 14px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            }

            .cart-table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.4rem 0 !important;
                border: none;
                flex-wrap: wrap;
            }

            .cart-table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark-grey);
                flex: 0 0 110px;
            }

            .cart-table tbody td:last-child {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-start;
                flex-wrap: wrap;
                padding-top: 1rem !important;
            }

            .cart-table tbody td:last-child:before {
                content: "Aksi: ";
            }

            .qty-input {
                width: 80px !important;
            }

            .total-section {
                text-align: center;
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
                <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
            </ol>
        </nav>

        <h1 class="cart-header"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h1>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-5"
                style="background: white; border-radius: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                <p class="text-muted">Keranjangmu masih kosong.</p>
                <a href="?page=products" class="btn btn-primary">Jelajahi Kado Spesial</a>
            </div>
        <?php else: ?>
            <div class="cart-card">
                <form method="post" action="?page=cart_update">
                    <table class="table cart-table align-middle">
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
                            foreach ($cart as $index => $item):
                                $price = $item['price'];
                                $qty = $item['qty'];
                                $subtotal = $price * $qty;
                                $total += $subtotal;
                                ?>
                                <tr>
                                    <td data-label="Produk">
                                        <?= htmlspecialchars($item['name']) ?>
                                        <?php if (!empty($item['custom_text'])): ?>
                                            <div class="small text-muted">Teks: <?= htmlspecialchars($item['custom_text']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Harga">Rp <?= number_format($price, 0, ',', '.') ?></td>
                                    <td data-label="Qty">
                                        <input type="number" name="qty[<?= $index ?>]" value="<?= $qty ?>" min="1"
                                            class="form-control form-control-sm qty-input" style="width:80px;">
                                    </td>
                                    <td data-label="Subtotal">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    <td data-label="Personalisasi">
                                        <?php if (empty($item['custom_id'])): ?>
                                            <a href="?page=custom_form&cart_index=<?= $index ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-paint-brush me-1"></i> Personalisasi
                                            </a>
                                        <?php else: ?>
                                            <div class="personalization-detail small">
                                                <b>Detail Personalisasi:</b><br>
                                                Teks: <?= htmlspecialchars($item['custom_text'] ?? '-') ?><br>
                                                Font: <?= htmlspecialchars($item['custom_font'] ?? '-') ?><br>
                                                Warna: <?= htmlspecialchars($item['custom_color'] ?? '-') ?><br>
                                                Packaging: <?= htmlspecialchars($item['custom_packaging'] ?? '-') ?><br>
                                                Pita: <?= htmlspecialchars($item['custom_ribbon'] ?? '-') ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Aksi">
                                        <a href="?page=remove_from_cart&id=<?= $index ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus <?= addslashes(htmlspecialchars($item['name'])) ?> dari keranjang?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="d-flex flex-wrap justify-content-between align-items-center cart-actions mt-4">
                        <div>
                            <button type="submit" formaction="?page=cart_update" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sync me-1"></i> Update Jumlah
                            </button>
                            <a href="?page=products" class="btn btn-outline-secondary btn-sm ms-2">
                                <i class="fas fa-plus me-1"></i> Tambah Kado
                            </a>
                        </div>
                        <div class="total-section">
                            <h5>Total: Rp <?= number_format($total, 0, ',', '.') ?></h5>
                            <a href="?page=checkout" class="btn btn-light fw-bold" style="width: 100%; max-width: 200px;">
                                Lanjut ke Checkout <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>