<?php // app/views/admin/products.php
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="?page=admin_dashboard" class="btn btn-link">← Dashboard</a>
        <h3>Daftar Produk</h3>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <a href="?page=admin_product_form" class="btn btn-success mb-3">+ Tambah Produk</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stock</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary"
                                href="?page=admin_product_edit&id=<?= $p['id'] ?>">Edit</a>
                            <a class="btn btn-sm btn-outline-danger" href="?page=admin_product_delete&id=<?= $p['id'] ?>"
                                onclick="return confirm('Hapus produk ini?')">Hapus</a>
                            <a class="btn btn-sm btn-outline-secondary"
                                href="?page=product_detail&id=<?= $p['id'] ?>">Detail</a>
                            <a href="?page=admin_order_reviews&id=<?= $p['id'] ?>" class="btn btn-sm btn-success">Lihat
                                Review</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>