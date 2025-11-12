<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();

$id = $_GET['id'];
$consultation = $db->prepare("SELECT c.*, u.name AS customer_name FROM consultations c LEFT JOIN users u ON c.user_id = u.id WHERE c.id = ?");
$consultation->execute([$id]);
$c = $consultation->fetch();

$suggestions = $db->prepare("
  SELECT cs.*, p.name AS product_name, p.price
  FROM consultation_suggestions cs
  LEFT JOIN products p ON cs.product_id = p.id
  WHERE cs.consultation_id = ?
");
$suggestions->execute([$id]);
$suggestions = $suggestions->fetchAll();

$feedback = $db->prepare("SELECT * FROM consultation_feedback WHERE consultation_id = ?");
$feedback->execute([$id]);
$feedback = $feedback->fetch();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Detail Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>🧾 Detail Konsultasi #<?= $c['id'] ?></h3>
        <p><strong>Customer:</strong> <?= htmlspecialchars($c['customer_name']) ?></p>
        <p><strong>Topik:</strong> <?= htmlspecialchars($c['topic']) ?></p>
        <p><strong>Budget:</strong> Rp <?= number_format($c['budget'], 0, ',', '.') ?></p>
        <p><strong>Status:</strong> <span class="badge bg-info"><?= ucfirst($c['status']) ?></span></p>
        <hr>

        <h5>💡 Rekomendasi Produk</h5>
        <?php if ($suggestions): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Alasan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suggestions as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['product_name']) ?></td>
                            <td>Rp <?= number_format($s['price'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($s['reason']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($s['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><em>Belum ada rekomendasi diberikan.</em></p>
        <?php endif; ?>

        <hr>
        <h5>🗣️ Feedback User</h5>
        <?php if ($feedback): ?>
            <p><strong>Kepuasan:</strong> <?= ucfirst($feedback['satisfaction']) ?></p>
            <p><strong>Follow Up:</strong> <?= $feedback['follow_up'] ? 'Ya' : 'Tidak' ?></p>
            <?php if ($feedback['whatsapp_link']): ?>
                <p><a href="<?= $feedback['whatsapp_link'] ?>" target="_blank" class="btn btn-sm btn-success">Hubungi via
                        WhatsApp</a></p>
            <?php endif; ?>
        <?php else: ?>
            <p><em>Belum ada feedback dari user.</em></p>
        <?php endif; ?>

        <a href="?page=admin_consultations" class="btn btn-secondary mt-3">⬅️ Kembali</a>
    </div>
</body>

</html>