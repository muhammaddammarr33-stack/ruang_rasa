<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container-fluid">

        <h4 class="mb-3">Daftar Pesanan</h4>

        <!-- FILTER BAR -->
        <form method="get" class="row g-3 align-items-end mb-4">
            <input type="hidden" name="page" value="admin_orders">

            <div class="col-md-3">
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
            unset($exportQuery['page']); // buang route
            unset($exportQuery['p']);    // buang nomor halaman
            ?>
            <a href="?page=admin_order_export&<?= http_build_query($exportQuery) ?>" class="btn btn-success btn-sm">
                Export CSV
            </a>
        </div>

        <!-- TABLE -->
        <table class="table table-bordered">
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
                            <td><?= htmlspecialchars($o['payment_status']) ?></td>
                            <td><?= htmlspecialchars($o['order_status']) ?></td>
                            <td><?= $o['created_at'] ?></td>
                            <td>
                                <a href="?page=admin_order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">Tidak ada pesanan ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- PAGINATION -->
        <?php
        $pages = ceil($total / $perPage);
        ?>
        <?php if ($pages > 1): ?>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link"
                                href="?page=admin_orders&<?= http_build_query(array_merge($_GET, ['p' => $i])) ?>" ">
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