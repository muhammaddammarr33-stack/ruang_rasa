<!-- app/views/user/order_detail.php -->
<?php
// Fallback jika variabel tidak dikirim (untuk keamanan)
$shipping = $shipping ?? null;
$items = $items ?? [];
$customOrders = $customOrders ?? [];
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan | Ruang Rasa</title>

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
            padding: 1.5rem 0;
        }

        .order-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .order-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            padding: 0.45rem 1rem;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-block;
        }

        .status-completed {
            background-color: rgba(231, 164, 148, 0.25);
            color: var(--soft-peach);
        }

        .status-pending,
        .status-processing {
            background-color: rgba(121, 161, 191, 0.15);
            color: var(--soft-blue);
        }

        .order-table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .order-table thead th {
            background-color: #f9fafc;
            font-weight: 600;
            color: var(--dark-grey);
            padding: 1rem;
        }

        .order-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-table tbody tr:last-child td {
            border-bottom: none;
        }

        .order-table tfoot th {
            background-color: #f9fafc;
            font-weight: 700;
            color: var(--soft-blue);
            padding: 1rem;
        }

        .custom-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #f5f5f5;
        }

        .color-preview {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin: 0 0.4rem;
            vertical-align: middle;
        }

        .btn-back {
            background-color: #f0f0f0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-back:hover {
            background-color: #e0e0e0;
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

        .section-title {
            font-weight: 700;
            margin: 2.5rem 0 1.25rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .section-title i {
            color: var(--soft-blue);
        }

        .text-total {
            color: var(--soft-blue);
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .order-card {
                padding: 1.5rem;
            }

            .order-table thead {
                display: none;
            }

            .order-table,
            .order-table tbody,
            .order-table tr,
            .order-table td {
                display: block;
                width: 100%;
            }

            .order-table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid #eee;
            }

            .order-table td::before {
                content: attr(data-label) ": ";
                position: absolute;
                left: 1rem;
                width: 45%;
                text-align: left;
                font-weight: 600;
                color: var(--dark-grey);
            }

            .order-table tfoot td {
                font-weight: 700;
                color: var(--soft-blue);
            }

            .btn-back {
                width: 100%;
                justify-content: center;
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
                <li class="breadcrumb-item"><a href="?page=orders">Riwayat Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>

        <h1 class="order-header">
            <i class="fas fa-box-open" aria-hidden="true"></i> Detail Pesanan #<?= (int) $order['id'] ?>
        </h1>

        <!-- Info Pesanan -->
        <div class="order-card">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <p>
                        <strong>Status Pesanan:</strong><br>
                        <span class="status-badge <?=
                            $order['order_status'] === 'completed' ? 'status-completed' : 'status-pending'
                            ?>">
                            <?= htmlspecialchars(ucfirst($order['order_status']), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </p>
                    <p>
                        <strong>Metode Pembayaran:</strong><br>
                        <?= htmlspecialchars(ucfirst($order['payment_method'] ?? '–'), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Alamat Pengiriman:</strong><br>
                        <span
                            class="text-muted"><?= nl2br(htmlspecialchars($order['shipping_address'] ?? '–', ENT_QUOTES, 'UTF-8')) ?></span>
                    </p>
                </div>
            </div>

            <h4 class="mt-4 mb-3">Informasi Pengiriman</h4>
            <?php if (!empty($shipping)): ?>
                <p><strong>Kurir:</strong> <b><?= htmlspecialchars($shipping['courier'] ?? '–', ENT_QUOTES, 'UTF-8') ?></b>
                </p>
                <p><strong>Ongkir:</strong> Rp <?= number_format((int) ($shipping['shipping_cost'] ?? 0), 0, ',', '.') ?>
                </p>
                <p><strong>Status Pengiriman:</strong>
                    <b><?= htmlspecialchars(strtoupper($shipping['status'] ?? '–'), ENT_QUOTES, 'UTF-8') ?></b></p>
                <?php if (!empty($shipping['tracking_number'])): ?>
                    <p><strong>Nomor Resi:</strong> <?= htmlspecialchars($shipping['tracking_number'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada data pengiriman.</p>
            <?php endif; ?>
        </div>

        <!-- Produk -->
        <h2 class="section-title">
            <i class="fas fa-shopping-cart" aria-hidden="true"></i> Produk yang Dipesan
        </h2>
        <div class="table-responsive">
            <table class="order-table">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    foreach ($items as $it):
                        $subtotal += (int) $it['subtotal'];
                        ?>
                        <tr>
                            <td data-label="Produk"><?= htmlspecialchars($it['product_name'] ?? '–', ENT_QUOTES, 'UTF-8') ?>
                            </td>
                            <td data-label="Harga">Rp <?= number_format((int) $it['price'], 0, ',', '.') ?></td>
                            <td data-label="Qty"><?= (int) $it['quantity'] ?></td>
                            <td data-label="Subtotal">Rp <?= number_format((int) $it['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" data-label="Ongkos Kirim" class="text-end fw-semibold">Ongkos Kirim</td>
                        <td class="fw-semibold">
                            <?php if (!empty($shipping)): ?>
                                Rp <?= number_format((int) $shipping['shipping_cost'], 0, ',', '.') ?>
                            <?php else: ?>
                                <span class="text-muted">–</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Pembayaran</th>
                        <th class="text-total">
                            Rp
                            <?= number_format($subtotal + (!empty($shipping) ? (int) $shipping['shipping_cost'] : 0), 0, ',', '.') ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Personalisasi -->
        <?php if (!empty($customOrders)): ?>
            <h2 class="section-title mt-4">
                <i class="fas fa-paint-brush" aria-hidden="true"></i> Detail Personalisasi
            </h2>
            <?php foreach ($customOrders as $co): ?>
                <div class="custom-card" role="region"
                    aria-label="Personalisasi untuk <?= htmlspecialchars($co['product_name'], ENT_QUOTES, 'UTF-8') ?>">
                    <h6 class="fw-bold mb-2"><?= htmlspecialchars($co['product_name'], ENT_QUOTES, 'UTF-8') ?></h6>
                    <p class="mb-1"><strong>Teks:</strong>
                        "<?= htmlspecialchars($co['custom_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>"</p>
                    <p class="mb-1"><strong>Gaya Tulisan:</strong>
                        <?= htmlspecialchars(ucfirst($co['font_style'] ?? 'Normal'), ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="mb-1">
                        <strong>Warna Teks:</strong>
                        <span class="color-preview"
                            style="background:<?= htmlspecialchars($co['text_color'] ?? '#000000', ENT_QUOTES, 'UTF-8') ?>;"></span>
                        <?= htmlspecialchars($co['text_color'] ?? '#000000', ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <p class="mb-1"><strong>Kemasan:</strong>
                        <?= htmlspecialchars(ucfirst($co['packaging_type'] ?? 'Box'), ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="mb-1">
                        <strong>Warna Pita:</strong>
                        <span class="color-preview"
                            style="background:<?= htmlspecialchars($co['ribbon_color'] ?? '#ffffff', ENT_QUOTES, 'UTF-8') ?>;"></span>
                        <?= htmlspecialchars($co['ribbon_color'] ?? '#ffffff', ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <?php if (!empty($co['special_instructions'])): ?>
                        <p class="mb-0">
                            <strong>Catatan Khusus:</strong><br>
                            <span
                                class="text-muted"><?= nl2br(htmlspecialchars($co['special_instructions'], ENT_QUOTES, 'UTF-8')) ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="d-flex justify-content-end mt-4">
            <a href="?page=orders" class="btn-back" aria-label="Kembali ke riwayat pesanan">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>
</body>

</html>