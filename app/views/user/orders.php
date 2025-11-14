<!-- app/views/user/orders.php -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pesanan | Ruang Rasa</title>

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

        .orders-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .orders-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 1.75rem;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--dark-grey);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1.1rem 1rem;
            vertical-align: middle;
        }

        /* Status badge sesuai brand */
        .status-badge {
            padding: 0.4rem 0.9rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-block;
        }

        .status-waiting,
        .status-processing,
        .status-shipped {
            background-color: rgba(121, 161, 191, 0.15);
            color: var(--soft-blue);
        }

        .status-completed {
            background-color: rgba(231, 164, 148, 0.2);
            color: var(--dark-grey);
        }

        .status-cancelled {
            background-color: rgba(239, 68, 68, 0.1);
            color: #e74c3c;
        }

        .btn-outline-primary {
            color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-outline-primary:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        .personalization-preview {
            font-size: 0.85rem;
            background: rgba(121, 161, 191, 0.05);
            padding: 0.6rem;
            border-radius: 10px;
            margin-top: 0.5rem;
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
            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1.25rem;
                padding: 1.25rem;
                background: white;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0 !important;
                flex-wrap: wrap;
            }

            .table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark-grey);
                flex: 0 0 120px;
            }

            .table tbody td:last-child {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-start;
                flex-wrap: wrap;
                padding-top: 1rem !important;
            }

            .table tbody td:last-child:before {
                content: "Aksi: ";
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
                <li class="breadcrumb-item active" aria-current="page">Riwayat Pesanan</li>
            </ol>
        </nav>

        <h1 class="orders-header">
            <i class="fas fa-shopping-bag"></i> Riwayat Pesanan Saya
        </h1>

        <?php if (!empty($orders)): ?>
            <div class="orders-card">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Personalisasi</th>
                                <th>Aksi</th>
                                <th>Resi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td data-label="ID">#<?= htmlspecialchars($o['id']) ?></td>
                                    <td data-label="Tanggal"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                                    <td data-label="Status">
                                        <?php
                                        $statusClass = match ($o['order_status']) {
                                            'completed' => 'status-completed',
                                            'cancelled' => 'status-cancelled',
                                            default => 'status-' . $o['order_status']
                                        };
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>">
                                            <?= ucfirst($o['order_status']) ?>
                                        </span>
                                    </td>
                                    <td data-label="Metode"><?= ucfirst($o['payment_method']) ?></td>
                                    <td data-label="Total">Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                                    <td data-label="Personalisasi">
                                        <?php
                                        $customList = $customOrdersByOrder[$o['id']] ?? [];
                                        if (!empty($customList)):
                                            ?>
                                            <div class="personalization-preview">
                                                <?php foreach ($customList as $co): ?>
                                                    <div>
                                                        <b><?= htmlspecialchars($co['product_name']) ?>:</b><br>
                                                        "<?= htmlspecialchars($co['custom_text']) ?>"
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Aksi">
                                        <a href="?page=order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                    <td data-label="Resi">
                                        <a href="?page=invoice&id=<?= $o['id'] ?>" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            Download Invoice </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5"
                style="background: white; border-radius: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-shopping-bag fa-2x text-muted mb-3"></i>
                <p class="text-muted">Belum ada pesanan.</p>
                <a href="?page=products" class="btn btn-primary">Jelajahi Kado Spesial</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>