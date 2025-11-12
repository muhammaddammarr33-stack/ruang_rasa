<?php // app/views/admin/categories.php ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="?page=admin_dashboard" class="btn btn-link">← Dashboard</a>
        <h3>Daftar Kategori</h3>
        <a href="?page=admin_category_form" class="btn btn-success mb-3">+ Tambah Kategori</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><?= htmlspecialchars($c['slug']) ?></td>
                        <td>
                            <a href="?page=admin_category_delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>