<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Manajemen Promosi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h3 class="mb-3">🎯 Daftar Promosi</h3>
        <a href="?page=admin_promo_form" class="btn btn-primary mb-3">+ Tambah Promosi</a>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Diskon</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($promos)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada promosi.</td>
                    </tr>
                <?php else:
                    foreach ($promos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['type']) ?></td>
                            <td><?= $p['discount'] ?>%</td>
                            <td><?= $p['start_date'] ?> → <?= $p['end_date'] ?></td>
                            <td>
                                <a href="?page=admin_promo_form&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                <a href="?page=admin_promo_delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus promosi ini?')">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>