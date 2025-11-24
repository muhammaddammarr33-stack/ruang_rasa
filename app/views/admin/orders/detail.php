<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Order #<?= $order['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .timeline {
            border-left: 2px solid #ccc;
            margin-left: 10px;
            padding-left: 15px;
        }

        .timeline-item {
            margin-bottom: 15px;
            position: relative;
        }

        .timeline-item:before {
            content: "";
            width: 12px;
            height: 12px;
            background: #0d6efd;
            border-radius: 50%;
            position: absolute;
            left: -20px;
            top: 4px;
        }
    </style>
</head>

<body class="p-4">
    <div class="container-fluid">

        <a href="?page=admin_orders" class="btn btn-sm btn-secondary mb-3">← Kembali</a>
        <h4>Order #<?= $order['id'] ?> — <?= htmlspecialchars($order['user_name'] ?? 'Guest') ?></h4>

        <!-- ALERT -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="row">
            <!-- LEFT CONTENT -->
            <div class="col-md-8">

                <h4>Shipping</h4>

                <p>Kurir: <b><?= $shipping['courier'] ?></b></p>
                <p>Ongkir: Rp <?= number_format($shipping['shipping_cost']) ?></p>
                <p>Status: <b><?= $shipping['status'] ?></b></p>

                <form action="?page=admin_shipping_update_tracking" method="post" class="mb-3">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <label class="form-label">Nomor Resi:</label>
                    <input type="text" name="tracking_number" value="<?= $shipping['tracking_number'] ?>"
                        class="form-control">
                    <button class="btn btn-primary mt-2">Update Resi</button>
                </form>

                <form action="?page=admin_shipping_update_status" method="post">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <label class="form-label">Status Pengiriman:</label>
                    <select class="form-select" name="status">
                        <option value="pending" <?= $shipping['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="shipped" <?= $shipping['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $shipping['status'] == 'delivered' ? 'selected' : '' ?>>Delivered
                        </option>
                    </select>
                    <button class="btn btn-success mt-2">Update Status</button>
                </form>


                <!-- PRODUK -->
                <div class="card mb-3 p-3">
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
                                            <img src="/uploads/<?= $it['product_image'] ?>" style="height:48px;margin-top:6px;">
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
                <div class="card mb-3 p-3">
                    <h6>Info Pembayaran</h6>

                    <?php if ($payment): ?>
                        <p>Gateway: <b><?= htmlspecialchars($payment['payment_gateway']) ?></b></p>
                        <p>Transaction ID: <?= htmlspecialchars($payment['transaction_id']) ?></p>
                        <p>Status: <b><?= htmlspecialchars($payment['status']) ?></b></p>
                    <?php else: ?>
                        <p class="text-muted">Belum ada record pembayaran.</p>
                    <?php endif; ?>
                </div>

                <!-- UPDATE STATUS -->
                <div class="card mb-3 p-3">
                    <h6>Update Status</h6>

                    <!-- ORDER STATUS -->
                    <form method="post" action="?page=admin_order_update" class="mb-2">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="field" value="order_status">

                        <div class="row g-2">
                            <div class="col-md-4">
                                <label>Status Pesanan</label>
                                <select name="new_status" class="form-select">
                                    <?php foreach (['waiting', 'processing', 'shipped', 'completed', 'cancelled'] as $s): ?>
                                        <option value="<?= $s ?>" <?= $order['order_status'] == $s ? 'selected' : '' ?>>
                                            <?= ucfirst($s) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Catatan</label>
                                <input type="text" name="note" class="form-control" placeholder="Opsional">
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary mt-4 w-100">Update</button>
                            </div>
                        </div>
                    </form>

                    <!-- PAYMENT STATUS -->
                    <form method="post" action="?page=admin_order_update">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="field" value="payment_status">

                        <div class="row g-2">
                            <div class="col-md-4">
                                <label>Status Pembayaran</label>
                                <select name="new_status" class="form-select">
                                    <?php foreach (['pending', 'paid', 'failed', 'refunded'] as $p): ?>
                                        <option value="<?= $p ?>" <?= $order['payment_status'] == $p ? 'selected' : '' ?>>
                                            <?= ucfirst($p) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Catatan</label>
                                <input type="text" name="note" class="form-control" placeholder="Opsional">
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-outline-primary mt-4 w-100">Update</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TIMELINE -->
                <div class="card mb-3 p-3">
                    <h6>Riwayat Status</h6>

                    <?php if (!empty($logs)): ?>
                        <div class="timeline">
                            <?php foreach ($logs as $l): ?>
                                <div class="timeline-item">
                                    <strong><?= htmlspecialchars($l['changed_by_name'] ?? 'System') ?></strong>
                                    <br>
                                    <?= $l['from_status'] ?> → <?= $l['to_status'] ?>
                                    <?php if ($l['note']): ?>
                                        <div><small>"<?= htmlspecialchars($l['note']) ?>"</small></div>
                                    <?php endif; ?>
                                    <div><small class="text-muted"><?= $l['created_at'] ?></small></div>
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

                <div class="card mb-3 p-3">
                    <h6>Customer & Pengiriman</h6>

                    <p><strong><?= htmlspecialchars($order['user_name']) ?></strong></p>
                    <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                    <p>Tracking: <b><?= htmlspecialchars($order['tracking_number'] ?? '-') ?></b></p>
                </div>

                <div class="card p-3">
                    <h6>Aksi</h6>

                    <a class="btn btn-sm btn-outline-primary mb-2" href="?page=invoice&id=<?= $order['id'] ?>">Cetak
                        Invoice</a>

                    <?php if (!in_array($order['order_status'], ['shipped', 'completed', 'cancelled'])): ?>
                        <button class="btn btn-sm btn-outline-danger mb-2" data-bs-toggle="modal"
                            data-bs-target="#cancelModal">
                            Cancel Order
                        </button>
                    <?php endif; ?>

                    <?php if ($order['payment_status'] === 'paid'): ?>
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#refundModal">
                            Refund
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->

    <!-- CANCEL MODAL -->
    <div class="modal fade" id="cancelModal">
        <div class="modal-dialog">
            <form method="post" action="?page=admin_order_cancel" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <label>Alasan Pembatalan</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Cancel Order</button>
                </div>
            </form>
        </div>
    </div>

    <!-- REFUND MODAL -->
    <div class="modal fade" id="refundModal">
        <div class="modal-dialog">
            <form method="post" action="?page=admin_order_refund" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refund Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                    <label>Jumlah Refund</label>
                    <input type="number" name="amount" class="form-control" max="<?= $order['total_amount'] ?>"
                        required>

                    <label class="mt-2">Catatan</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning">Proses Refund</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>