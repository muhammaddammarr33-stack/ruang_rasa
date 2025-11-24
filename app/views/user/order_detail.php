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
            padding: 1.75rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            padding: 0.4rem 0.9rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .status-completed {
            background-color: rgba(231, 164, 148, 0.2);
            color: var(--dark-grey);
        }

        .status-pending,
        .status-processing {
            background-color: rgba(121, 161, 191, 0.15);
            color: var(--soft-blue);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--dark-grey);
        }

        .table tfoot th {
            background-color: #f8fafc;
            font-weight: 700;
            color: var(--soft-blue);
        }

        .custom-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin: 0 0.3rem;
            vertical-align: middle;
        }

        .btn-back {
            background-color: #e0e0e0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-back:hover {
            background-color: #d0d0d0;
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
            margin: 2rem 0 1.25rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .section-title i {
            color: var(--soft-blue);
        }

        .text-soft-blue {
            color: var(--soft-blue) !important;
            font-weight: 700;
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
            <i class="fas fa-box-open"></i> Detail Pesanan #<?= $order['id'] ?>
        </h1>

        <!-- Info Pesanan -->
        <div class="order-card">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p><strong>Status Pesanan:</strong><br>
                        <span class="status-badge <?=
                            $order['order_status'] === 'completed' ? 'status-completed' : 'status-pending'
                            ?>">
                            <?= ucfirst($order['order_status']) ?>
                        </span>
                    </p>
                    <p><strong>Metode Pembayaran:</strong><br>
                        <?= ucfirst($order['payment_method']) ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Alamat Pengiriman:</strong><br>
                        <span class="text-muted"><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></span>
                    </p>
                </div>
                <h4>Informasi Pengiriman</h4>

                <?php if (!empty($shipping)): ?>
                    <p><strong>Kurir:</strong> <b><?= htmlspecialchars($shipping['courier']) ?></b></p>
                    <p><strong>Ongkir:</strong> Rp <?= number_format($shipping['shipping_cost'], 0, ',', '.') ?></p>
                    <p><strong>Status Pengiriman:</strong> <b><?= htmlspecialchars(strtoupper($shipping['status'])) ?></b>
                    </p>
                    <?php if (!empty($shipping['tracking_number'])): ?>
                        <p><strong>Nomor Resi:</strong> <?= htmlspecialchars($shipping['tracking_number']) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Belum ada data pengiriman.</p>
                <?php endif; ?>

            </div>
        </div>

        <!-- Produk -->
        <h2 class="section-title"><i class="fas fa-shopping-cart"></i> Produk yang Dipesan</h2>
        <div class="card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subtotal = 0;
                        foreach ($items as $it):
                            $subtotal += $it['subtotal'];
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($it['product_name']) ?></td>
                                <td>Rp <?= number_format($it['price'], 0, ',', '.') ?></td>
                                <td><?= $it['quantity'] ?></td>
                                <td>Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Baris Ongkos Kirim -->
                        <tr>
                            <td colspan="3" class="text-end"><strong>Ongkos Kirim</strong></td>
                            <td>
                                <?php if (!empty($shipping)): ?>
                                    Rp <?= number_format((int) $shipping['shipping_cost'], 0, ',', '.') ?>
                                <?php else: ?>
                                    <span class="text-muted">–</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="3" class="text-end">Total Pembayaran</th>
                            <th class="text-soft-blue">
                                Rp
                                <?= number_format($subtotal + (!empty($shipping) ? (int) $shipping['shipping_cost'] : 0), 0, ',', '.') ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Personalisasi -->
        <?php if (!empty($customOrders)): ?>
            <h2 class="section-title mt-4"><i class="fas fa-paint-brush"></i> Detail Personalisasi</h2>
            <?php foreach ($customOrders as $co): ?>
                <div class="custom-card">
                    <h6 class="fw-bold mb-2"><?= htmlspecialchars($co['product_name']) ?></h6>
                    <p class="mb-1"><strong>Teks:</strong> "<?= htmlspecialchars($co['custom_text']) ?>"</p>
                    <p class="mb-1"><strong>Gaya Tulisan:</strong> <?= htmlspecialchars(ucfirst($co['font_style'])) ?></p>
                    <p class="mb-1">
                        <strong>Warna Teks:</strong>
                        <span class="color-preview" style="background:<?= htmlspecialchars($co['text_color']) ?>;"></span>
                        <?= htmlspecialchars($co['text_color']) ?>
                    </p>
                    <p class="mb-1"><strong>Kemasan:</strong> <?= htmlspecialchars(ucfirst($co['packaging_type'])) ?></p>
                    <p class="mb-1">
                        <strong>Warna Pita:</strong>
                        <span class="color-preview" style="background:<?= htmlspecialchars($co['ribbon_color']) ?>;"></span>
                        <?= htmlspecialchars($co['ribbon_color']) ?>
                    </p>
                    <?php if (!empty($co['special_instructions'])): ?>
                        <p class="mb-0">
                            <strong>Catatan Khusus:</strong><br>
                            <span class="text-muted"><?= nl2br(htmlspecialchars($co['special_instructions'])) ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="text-end mt-4">
            <a href="?page=orders" class="btn btn-back">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>
</body>

</html>