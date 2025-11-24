<?php if ($shipping): ?>

    <h4>Shipping Information</h4>
    <p>Kurir: <b><?= $shipping['courier'] ?></b></p>
    <p>Ongkir: Rp <?= number_format($shipping['shipping_cost']) ?></p>
    <p>Status: <?= $shipping['status'] ?></p>

    <form method="post" action="?page=admin_shipping_update_tracking">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <label>Tracking Number:</label>
        <input type="text" name="tracking_number" value="<?= $shipping['tracking_number'] ?>" class="form-control">
        <button class="btn btn-primary mt-2">Update Resi</button>
    </form>

    <form method="post" action="?page=admin_shipping_update_status" class="mt-3">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <select name="status" class="form-select">
            <option value="pending">Pending</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
        </select>
        <button class="btn btn-success mt-2">Update Status</button>
    </form>

<?php endif; ?>