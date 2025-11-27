<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin - Rewards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container-fluid">
        <h4>Rewards (Kelola)</h4>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="?page=admin_rewards_form" class="btn btn-primary btn-sm">+ Tambah Reward</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Poin Diperlukan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rewards)):
                    foreach ($rewards as $r): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><?= htmlspecialchars($r['name']) ?></td>
                            <td><?= number_format($r['points_required']) ?></td>
                            <td><?= nl2br(htmlspecialchars($r['description'])) ?></td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="?page=admin_rewards_form&id=<?= $r['id'] ?>">Edit</a>
                                <a class="btn btn-sm btn-danger" href="?page=admin_rewards_delete&id=<?= $r['id'] ?>"
                                    onclick="return confirm('Hapus reward?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada reward</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>