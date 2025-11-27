<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order #<?= $order['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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
            padding: 1rem 1rem 1.5rem;
        }

        h4,
        h6 {
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        h4 {
            font-size: 1.25rem;
        }

        h6 {
            font-size: 1rem;
            color: var(--dark);
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: none;
            background: white;
            margin-bottom: 12px;
            padding: 12px;
        }

        .alert {
            font-size: 0.875rem;
            padding: 0.625rem 1rem;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            margin-bottom: 12px;
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

        .btn-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .btn-success:hover {
            background-color: #bcd0c7;
        }

        .btn-outline-primary {
            color: var(--accent);
            border-color: var(--accent);
        }

        .btn-outline-primary:hover {
            background-color: rgba(112, 147, 179, 0.08);
            border-color: var(--accent-hover);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: rgba(220, 53, 69, 0.08);
        }

        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
        }

        .btn-outline-warning:hover {
            background-color: rgba(255, 193, 7, 0.08);
        }

        table {
            font-size: 0.875rem;
        }

        table th,
        table td {
            padding: 0.5rem;
        }

        table thead th {
            background-color: #fafafa;
            font-weight: 600;
            font-size: 0.8125rem;
        }

        .timeline {
            border-left: 2px solid var(--border);
            margin-left: 12px;
            padding-left: 14px;
            position: relative;
        }

        .timeline-item {
            margin-bottom: 12px;
            position: relative;
        }

        .timeline-item:before {
            content: "";
            width: 10px;
            height: 10px;
            background: var(--accent);
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--accent);
            border-radius: 50%;
            position: absolute;
            left: -17px;
            top: 4px;
            z-index: 1;
        }

        .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.375rem;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            font-size: 0.875rem;
            padding: 0.4375rem 0.75rem;
            border-radius: 5px;
        }

        .modal-header {
            padding: 1rem 1rem 0.75rem;
        }

        .modal-body {
            padding: 0.75rem 1rem;
        }

        .modal-footer {
            padding: 0 1rem 1rem;
        }

        .product-img {
            height: 42px;
            margin-top: 4px;
            object-fit: cover;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <a href="?page=admin_orders" class="btn btn-sm btn-secondary mb-2">← Kembali</a>
        <h4>Order #<?= $order['id'] ?> — <?= htmlspecialchars($order['user_name'] ?? 'Guest') ?></h4>

        <!-- ALERT -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="row g-3">
            <!-- LEFT CONTENT -->
            <div class="col-md-8">
                <div class="card">
                    <h6>Shipping</h6>
                    <?php if ($shipping): ?>
                        <p>Kurir: <strong><?= htmlspecialchars($shipping['courier'] ?? '-') ?></strong></p>
                        <p>Ongkir: Rp <?= number_format($shipping['shipping_cost'] ?? 0, 0, ',', '.') ?></p>
                        <p>Status: <strong><?= htmlspecialchars($shipping['status'] ?? 'pending') ?></strong></p>

                        <form action="?page=admin_shipping_update_tracking" method="post" class="mb-2">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <label class="form-label">Nomor Resi:</label>
                            <input type="text" name="tracking_number"
                                value="<?= htmlspecialchars($shipping['tracking_number'] ?? '') ?>" class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Update Resi</button>
                        </form>

                        <form action="?page=admin_shipping_update_status" method="post">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <label class="form-label">Status Pengiriman:</label>
                            <select class="form-select" name="status">
                                <option value="pending" <?= ($shipping['status'] ?? 'pending') == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="shipped" <?= ($shipping['status'] ?? 'pending') == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="delivered" <?= ($shipping['status'] ?? 'pending') == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            </select>
                            <button type="submit" class="btn btn-success mt-2">Update Status</button>
                        </form>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data pengiriman.</p>
                    <?php endif; ?>
                </div>

                <!-- PRODUK -->
                <div class="card">
                    <h6>Detail Produk</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $it): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($it['product_name']) ?>
                                        <?php if (!empty($it['product_image'])): ?>
                                            <br>
                                            <img src="/uploads/<?= htmlspecialchars($it['product_image']) ?>"
                                                class="product-img">
                                        <?php endif; ?>
                                    </td>
                                    <td>Rp <?= number_format($it['price'], 0, ',', '.') ?></td>
                                    <td><?= $it['quantity'] ?></td>
                                    <td>Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-end fw-bold">Total: Rp <?= number_format($order['total_amount'], 0, ',', '.') ?>
                    </div>
                </div>

                <!-- PEMBAYARAN -->
                <div class="card">
                    <h6>Info Pembayaran</h6>
                    <?php if ($payment): ?>
                        <p>Gateway: <strong><?= htmlspecialchars($payment['payment_gateway']) ?></strong></p>
                        <p>Transaction ID: <?= htmlspecialchars($payment['transaction_id']) ?></p>
                        <p>Status: <strong><?= htmlspecialchars($payment['status']) ?></strong></p>
                    <?php else: ?>
                        <p class="text-muted">Belum ada record pembayaran.</p>
                    <?php endif; ?>
                </div>

                <!-- UPDATE STATUS -->
                <div class="card">
                    <h6>Update Status</h6>
                    <form method="post" action="?page=admin_order_update" class="row g-2 mb-3">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="field" value="order_status">
                        <div class="col-md-4">
                            <label class="form-label">Status Pesanan</label>
                            <select name="new_status" class="form-select">
                                <?php foreach (['waiting', 'processing', 'shipped', 'completed', 'cancelled'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $order['order_status'] == $s ? 'selected' : '' ?>>
                                        <?= ucfirst($s) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Catatan</label>
                            <input type="text" name="note" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary mt-4 w-100">Update</button>
                        </div>
                    </form>

                    <form method="post" action="?page=admin_order_update" class="row g-2">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="field" value="payment_status">
                        <div class="col-md-4">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="new_status" class="form-select">
                                <?php foreach (['pending', 'paid', 'failed', 'refunded'] as $p): ?>
                                    <option value="<?= $p ?>" <?= $order['payment_status'] == $p ? 'selected' : '' ?>>
                                        <?= ucfirst($p) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Catatan</label>
                            <input type="text" name="note" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary mt-4 w-100">Update</button>
                        </div>
                    </form>
                </div>

                <!-- TIMELINE -->
                <div class="card">
                    <h6>Riwayat Status</h6>
                    <?php if (!empty($logs)): ?>
                        <div class="timeline">
                            <?php foreach ($logs as $l): ?>
                                <div class="timeline-item">
                                    <strong><?= htmlspecialchars($l['changed_by_name'] ?? 'System') ?></strong><br>
                                    <?= htmlspecialchars($l['from_status']) ?> → <?= htmlspecialchars($l['to_status']) ?>
                                    <?php if (!empty($l['note'])): ?>
                                        <div><small>"<?= htmlspecialchars($l['note']) ?>"</small></div>
                                    <?php endif; ?>
                                    <div><small class="text-muted"><?= htmlspecialchars($l['created_at']) ?></small></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada log perubahan.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT SIDEBAR -->
            <div class="col-md-4">
                <div class="card">
                    <h6>Customer & Pengiriman</h6>
                    <p><strong><?= htmlspecialchars($order['user_name']) ?></strong></p>
                    <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                    <p>Tracking: <strong><?= htmlspecialchars($order['tracking_number'] ?? '-') ?></strong></p>
                </div>

                <div class="card">
                    <h6>Aksi</h6>
                    <a class="btn btn-sm btn-outline-primary w-100 mb-2"
                        href="?page=invoice&id=<?= $order['id'] ?>">Cetak Invoice</a>
                    <?php if (!in_array($order['order_status'], ['shipped', 'completed', 'cancelled'])): ?>
                        <button class="btn btn-sm btn-outline-danger w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#cancelModal">
                            Cancel Order
                        </button>
                    <?php endif; ?>
                    <?php if ($order['payment_status'] === 'paid'): ?>
                        <button class="btn btn-sm btn-outline-warning w-100" data-bs-toggle="modal"
                            data-bs-target="#refundModal">
                            Refund
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    <div class="modal fade" id="cancelModal">
        <div class="modal-dialog">
            <form method="post" action="?page=admin_order_cancel" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <label class="form-label">Alasan Pembatalan</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="refundModal">
        <div class="modal-dialog">
            <form method="post" action="?page=admin_order_refund" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refund Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <label class="form-label">Jumlah Refund</label>
                    <input type="number" name="amount" class="form-control" max="<?= $order['total_amount'] ?>"
                        required>
                    <label class="form-label mt-2">Catatan</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Proses Refund</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>