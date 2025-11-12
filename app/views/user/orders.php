<?php
require_once __DIR__ . '/../../models/DB.php';
require_once __DIR__ . '/../../models/Payment.php';
require_once __DIR__ . '/../../models/CustomOrder.php';

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

$user = $_SESSION['user'];
$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    echo "<div style='padding:20px;'>⚠️ ID Pesanan tidak ditemukan. <a href='?page=user_dashboard'>Kembali</a></div>";
    exit;
}

$db = DB::getInstance();

// ==========================
// 🔹 Ambil data order utama
// ==========================
$stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$orderId, $user['id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<div style='padding:20px;'>⚠️ Pesanan tidak ditemukan untuk user ini. <a href='?page=user_dashboard'>Kembali</a></div>";
    exit;
}

// ==========================
// 🔹 Ambil daftar item produk
// ==========================
$stmtItems = $db->prepare("
    SELECT oi.*, p.name 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE order_id = ?
");
$stmtItems->execute([$orderId]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

// ==========================
// 🔹 Ambil data pembayaran
// ==========================
$paymentModel = new Payment();
$payment = $paymentModel->getByOrder($orderId);

// ==========================
// 🔹 Ambil data personalisasi (jika ada)
// ==========================
$stmtCustom = $db->prepare("
    SELECT co.*, p.name AS product_name
    FROM custom_orders co
    JOIN products p ON co.product_id = p.id
    WHERE co.order_id = ?
");
$stmtCustom->execute([$orderId]);
$customs = $stmtCustom->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Detail Pesanan #<?= $orderId ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3 class="mb-3">🧾 Detail Pesanan #<?= $orderId ?></h3>

        <div class="card mb-4">
            <div class="card-body">
                <p><b>Status Pesanan:</b>
                    <span class="badge bg-info text-dark"><?= ucfirst($order['order_status']) ?></span>
                </p>
                <p><b>Status Pembayaran:</b>
                    <span class="badge bg-<?= $order['payment_status'] === 'paid' ? 'success' : 'warning' ?>">
                        <?= ucfirst($order['payment_status']) ?>
                    </span>
                    (<?= htmlspecialchars($order['payment_method']) ?>)
                </p>
                <p><b>Alamat Pengiriman:</b><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                <p><small><i>Dipesan pada <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></i></small></p>
            </div>
        </div>

        <!-- PRODUK -->
        <h5>🛍️ Daftar Produk</h5>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
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
                        <td><?= htmlspecialchars($it['name']) ?></td>
                        <td>Rp <?= number_format($it['price'], 0, ',', '.') ?></td>
                        <td><?= $it['quantity'] ?></td>
                        <td>Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h5 class="text-end">Total: Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></h5>

        <!-- PERSONALISASI -->
        <?php if (!empty($customs)): ?>
            <h5 class="mt-4">🎨 Personalisasi Produk</h5>
            <?php foreach ($customs as $c): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><?= htmlspecialchars($c['product_name']) ?></h6>
                        <ul class="mb-0">
                            <?php if (!empty($c['custom_text'])): ?>
                                <li><b>Teks Ucapan:</b> <?= htmlspecialchars($c['custom_text']) ?></li>
                            <?php endif; ?>
                            <?php if (!empty($c['font_style'])): ?>
                                <li><b>Font:</b> <?= htmlspecialchars($c['font_style']) ?></li>
                            <?php endif; ?>
                            <?php if (!empty($c['text_color'])): ?>
                                <li><b>Warna Teks:</b> <span style="color: <?= htmlspecialchars($c['text_color']) ?>;">
                                        <?= htmlspecialchars($c['text_color']) ?></span></li>
                            <?php endif; ?>
                            <?php if (!empty($c['packaging_type'])): ?>
                                <li><b>Kemasan:</b> <?= htmlspecialchars($c['packaging_type']) ?></li>
                            <?php endif; ?>
                            <?php if (!empty($c['ribbon_color'])): ?>
                                <li><b>Warna Pita:</b> <?= htmlspecialchars($c['ribbon_color']) ?></li>
                            <?php endif; ?>
                            <?php if (!empty($c['special_instructions'])): ?>
                                <li><b>Instruksi Tambahan:</b> <?= nl2br(htmlspecialchars($c['special_instructions'])) ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- PEMBAYARAN -->
        <?php if ($payment): ?>
            <h5 class="mt-4">💳 Informasi Pembayaran</h5>
            <div class="card mb-3">
                <div class="card-body">
                    <p><b>Gateway:</b> <?= htmlspecialchars($payment['payment_gateway']) ?></p>
                    <p><b>Transaction ID:</b> <?= htmlspecialchars($payment['transaction_id']) ?></p>
                    <p><b>Status:</b>
                        <span class="badge bg-<?= $payment['status'] === 'success' ? 'success' : 'warning' ?>">
                            <?= htmlspecialchars($payment['status']) ?>
                        </span>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- ULASAN -->
        <?php if ($order['order_status'] === 'completed' && !empty($items)): ?>
            <a href="?page=add_review_after_purchase&product_id=<?= $items[0]['product_id'] ?>"
                class="btn btn-outline-primary btn-sm">📝 Beri Ulasan</a>
        <?php endif; ?>

        <a href="?page=user_dashboard" class="btn btn-secondary mt-3">⬅️ Kembali</a>
    </div>
</body>

</html>