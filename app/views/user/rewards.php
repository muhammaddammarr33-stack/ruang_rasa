<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Rewards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h4>Reward Catalog</h4>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php
        require_once __DIR__ . '/../../models/Memberships.php';
        $ms = new Memberships();
        $mem = isset($_SESSION['user']) ? $ms->get($_SESSION['user']['id']) : null;
        ?>

        <div class="mb-3">
            <strong>Poin Anda:</strong> <?= $mem ? number_format($mem['points']) : '0' ?>
            <?php if ($mem): ?><small class="text-muted"> (Tier:
                    <?= htmlspecialchars($mem['tier']) ?>)</small><?php endif; ?>
        </div>

        <div class="row">
            <?php if (!empty($rewards)):
                foreach ($rewards as $r): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card p-3 h-100">
                            <h6><?= htmlspecialchars($r['name']) ?></h6>
                            <p class="small text-muted"><?= nl2br(htmlspecialchars($r['description'])) ?></p>
                            <div class="mt-auto">
                                <div class="mb-2">Butuh <?= number_format($r['points_required']) ?> poin</div>
                                <?php if (!isset($_SESSION['user'])): ?>
                                    <a href="?page=login" class="btn btn-primary btn-sm w-100">Login untuk Redeem</a>
                                <?php else: ?>
                                    <?php $have = $mem['points'] ?? 0; ?>
                                    <?php if ($have >= $r['points_required']): ?>
                                        <a href="?page=claim_reward&id=<?= $r['id'] ?>" class="btn btn-success btn-sm w-100"
                                            onclick="return confirm('Redeem reward ini?')">Redeem</a>
                                    <?php else: ?>
                                        <button class="btn btn-outline-secondary btn-sm w-100" disabled>Butuh lebih banyak poin</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                <div class="col-12 text-muted">Belum ada reward tersedia.</div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>