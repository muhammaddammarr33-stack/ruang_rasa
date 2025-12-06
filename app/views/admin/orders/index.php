<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --accent: #7093B3;
            --accent-hover: #5d7da0;
            --dark: #343D46;
            --muted: #6c757d;
            --border: #e9ecef;
        }

        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', system-ui, sans-serif;
            color: var(--dark);
            font-size: 0.875rem;
            padding: 1rem;
        }

        h4 {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .form-label {
            font-size: 0.8125rem;
            margin-bottom: 0.375rem;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            font-size: 0.875rem;
            padding: 0.4375rem 0.75rem;
            border-radius: 5px;
        }

        .btn {
            font-size: 0.8125rem;
            padding: 0.375rem 0.625rem;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--accent);
            border: 1px solid var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }



        .pagination .page-link {
            color: var(--accent);
            border-color: var(--border);
            font-size: 0.875rem;
            padding: 0.375rem 0.625rem;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
        }

        .empty-row {
            font-size: 0.875rem;
            color: var(--muted);
            padding: 1rem;
            text-align: center;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
            font-size: 0.8125rem;
        }

        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--muted);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="?page=admin_dashboard">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
        <h4>Daftar Pesanan</h4>

        <!-- FILTER BAR -->
        <form method="get" class="row g-2 align-items-end mb-3">
            <input type="hidden" name="page" value="admin_orders">
            <div class="col-md-2">
                <label class="form-label">Cari (ID / Nama / Resi)</label>
                <input name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status Pesanan</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <?php foreach (['waiting', 'processing', 'shipped', 'completed', 'cancelled'] as $s): ?>
                        <option value="<?= $s ?>" <?= (($_GET['status'] ?? '') === $s) ? 'selected' : '' ?>>
                            <?= ucfirst($s) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status Pembayaran</label>
                <select name="payment_status" class="form-select">
                    <option value="">Semua</option>
                    <?php foreach (['pending', 'paid', 'failed', 'refunded'] as $p): ?>
                        <option value="<?= $p ?>" <?= (($_GET['payment_status'] ?? '') === $p) ? 'selected' : '' ?>>
                            <?= ucfirst($p) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dari</label>
                <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>"
                    class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Sampai</label>
                <input type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>"
                    class="form-control">
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <!-- EXPORT -->
        <div class="mb-3">
            <?php
            $exportQuery = $_GET;
            unset($exportQuery['page']);
            unset($exportQuery['p']);
            ?>
            <a href="?page=admin_order_export&<?= http_build_query($exportQuery) ?>"
                class="btn btn-outline-success btn-sm">
                Export CSV
            </a>
        </div>

        <!-- TABLE -->
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['user_name'] ?? 'Guest') ?></td>
                            <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                            <td><?= ucfirst(htmlspecialchars($o['payment_status'])) ?></td>
                            <td><?= ucfirst(htmlspecialchars($o['order_status'])) ?></td>
                            <td><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
                            <td>
                                <a href="?page=admin_order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="empty-row">Tidak ada pesanan ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- PAGINATION -->
        <?php
        $pages = ceil($total / $perPage);
        ?>
        <?php if ($pages > 1): ?>
            <nav aria-label="Pagination">
                <ul class="pagination pagination-sm">
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</body>

</html>
