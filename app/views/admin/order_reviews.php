<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Review Produk Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Review Produk untuk Pesanan #<?= $_GET['id'] ?></h3>

        <?php if (count($reviews) > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Reviewer</th>
                        <th>Rating</th>
                        <th>Ulasan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['product_name']) ?></td>
                            <td><?= htmlspecialchars($r['reviewer'] ?? '-') ?></td>
                            <td><?= $r['rating'] ? str_repeat('⭐', $r['rating']) : '<span class="text-muted">Belum Ada</span>' ?>
                            </td>
                            <td><?= $r['review'] ? htmlspecialchars($r['review']) : '<i class="text-muted">Belum ada ulasan</i>' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">Belum ada produk untuk pesanan ini.</p>
        <?php endif; ?>

        <a href="?page=admin_products" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>

</html>