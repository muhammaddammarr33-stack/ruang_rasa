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

        /* Custom Buttons — konsisten dengan desain Ruang Rasa */
        .btn-primary-custom {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            font-weight: 600;
            color: white;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary-custom:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-secondary-custom {
            background-color: #e0e0e0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background-color 0.2s;
        }

        .btn-secondary-custom:hover {
            background-color: #d0d0d0;
        }

        .btn-outline-custom {
            color: var(--soft-blue);
            border: 1px solid var(--soft-blue);
            background: transparent;
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.25s;
        }

        .btn-outline-custom:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        .btn-warning-custom {
            background-color: #fde047;
            color: #333;
            border: none;
            border-radius: 10px;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .btn-danger-custom {
            background-color: #fca5a5;
            color: #991b1b;
            border: none;
            border-radius: 10px;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .form-control-sm {
            border-radius: 8px;
            padding: 0.35rem 0.5rem;
            border: 1px solid #ddd;
        }

        .form-control-sm:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.1);
            outline: none;
        }

        .personalization-detail {
            font-size: 0.85rem;
            background: rgba(121, 161, 191, 0.05);
            padding: 0.6rem;
            border-radius: 10px;
            margin-top: 0.5rem;
        }

        /* 🔹 TOTAL SECTION — TANPA GRADIENT */
        .total-section {
            background-color: var(--soft-blue);
            /* ✅ SOLID COLOR */
            color: white;
            padding: 1.25rem;
            border-radius: 16px;
            text-align: right;
            min-width: 220px;
        }

        .total-section h5 {
            margin-bottom: 0.75rem;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .checkout-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background: white;
            color: var(--soft-blue);
            font-weight: 700;
            padding: 0.7rem;
            border-radius: 12px;
            text-decoration: none;
            width: 100%;
            max-width: 200px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid white;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

        /* ——— Mobile Responsive ——— */
        @media (max-width: 768px) {
            .cart-actions {
                flex-direction: column;
                gap: 1.25rem;
                align-items: stretch;
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
                padding: 0.5rem 0 !important;
                border: none;
                flex-wrap: wrap;
            }

            .cart-table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark-grey);
                flex: 0 0 100px;
            }

            .cart-table tbody td:last-child {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                padding-top: 1rem !important;
            }

            .cart-table tbody td:last-child:before {
                content: "Aksi:";
                margin-bottom: 0.25rem;
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

        <h1 class="cart-header"><i class="fas fa-shopping-cart" aria-hidden="true"></i> Keranjang Belanja</h1>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert" aria-live="polite">
                <i class="fas fa-check-circle me-2" aria-hidden="true"></i><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-5"
                style="background: white; border-radius: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-shopping-cart fa-2x text-muted mb-3" aria-hidden="true"></i>
                <p class="text-muted">Keranjangmu masih kosong.</p>
                <a href="?page=products" class="btn-primary-custom">Jelajahi Kado Spesial</a>
            </div>
        <?php else: ?>
            <div class="cart-card">
                <form method="post" action="?page=cart_update">

                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Personalisasi</th>
                                <th scope="col">Aksi</th>
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
                                        <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                                        <?php if (!empty($item['custom_text'])): ?>
                                            <div class="small text-muted">Teks:
                                                <?= htmlspecialchars($item['custom_text'], ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Harga">Rp <?= number_format($price, 0, ',', '.') ?></td>
                                    <td data-label="Qty">
                                        <input type="number" name="qty[<?= (int) $index ?>]" value="<?= (int) $qty ?>" min="1"
                                            class="form-control form-control-sm qty-input" style="width:80px;">
                                    </td>
                                    <td data-label="Subtotal">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    <td data-label="Personalisasi">
                                        <?php if (empty($item['custom_id'])): ?>
                                            <a href="?page=custom_form&cart_index=<?= (int) $index ?>" class="btn-warning-custom">
                                                <i class="fas fa-paint-brush me-1" aria-hidden="true"></i> Personalisasi
                                            </a>
                                        <?php else: ?>
                                            <div class="personalization-detail small">
                                                <b>Detail Personalisasi:</b><br>
                                                Teks: <?= htmlspecialchars($item['custom_text'] ?? '-', ENT_QUOTES, 'UTF-8') ?><br>
                                                Font: <?= htmlspecialchars($item['custom_font'] ?? '-', ENT_QUOTES, 'UTF-8') ?><br>
                                                Warna:
                                                <?= htmlspecialchars($item['custom_color'] ?? '-', ENT_QUOTES, 'UTF-8') ?><br>
                                                Packaging:
                                                <?= htmlspecialchars($item['custom_packaging'] ?? '-', ENT_QUOTES, 'UTF-8') ?><br>
                                                Pita: <?= htmlspecialchars($item['custom_ribbon'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Aksi">
                                        <a href="?page=remove_from_cart&id=<?= (int) $index ?>" class="btn-danger-custom"
                                            onclick="return confirm('Yakin hapus <?= addslashes(htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8')) ?> dari keranjang?')">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="d-flex flex-wrap justify-content-between align-items-center cart-actions mt-4">
                        <div>
                            <button type="submit" formaction="?page=cart_update" class="btn-secondary-custom">
                                <i class="fas fa-sync me-1" aria-hidden="true"></i> Update Jumlah
                            </button>
                            <a href="?page=products" class="btn-outline-custom ms-2">
                                <i class="fas fa-plus me-1" aria-hidden="true"></i> Tambah Kado
                            </a>
                        </div>
                        <div class="total-section">
                            <h5>Total: Rp <?= number_format($total, 0, ',', '.') ?></h5>
                            <a href="?page=checkout" class="checkout-btn">
                                Lanjut ke Checkout <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
