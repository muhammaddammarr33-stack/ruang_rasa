<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Riwayat Penukaran Reward</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h3 class="mb-3">Riwayat Penukaran Reward</h3>

        <a href="?page=user_rewards" class="btn btn-secondary btn-sm mb-3">← Kembali</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Reward</th>
                    <th>Poin Dibutuhkan</th>
                    <th>Tanggal Redeem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($history)): ?>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td><?= htmlspecialchars($h['name']) ?></td>
                            <td><?= $h['points_required'] ?></td>
                            <td><?= $h['redeemed_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada penukaran reward</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>