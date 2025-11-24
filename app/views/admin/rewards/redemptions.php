<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Riwayat Penukaran Reward - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="container-fluid">
        <h3 class="mb-3">Riwayat Penukaran Reward (Admin)</h3>

        <a href="?page=admin_rewards" class="btn btn-secondary btn-sm mb-3">← Kembali</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Reward</th>
                    <th>Points Required</th>
                    <th>Tanggal Redeem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($history)): ?>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td><?= htmlspecialchars($h['user_name']) ?></td>
                            <td><?= htmlspecialchars($h['name']) ?></td>
                            <td><?= $h['points_required'] ?></td>
                            <td><?= $h['redeemed_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada yang redeem</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>