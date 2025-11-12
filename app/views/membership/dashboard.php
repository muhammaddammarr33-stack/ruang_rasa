<!-- <?php // app/views/membership/dashboard.php
// $userId = $_SESSION['user']['id'];
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Member Area</h3>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div><?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div><?php endif; ?>
        <div class="card mb-3">
            <div class="card-body">
                <p><b>Level:</b> <?= htmlspecialchars($membership['tier']) ?> | <b>Poin:</b>
                    <?= (int) $membership['points'] ?></p>
            </div>
        </div>

        <h5>Rewards</h5>
        <div class="row">
            <?php foreach ($rewards as $rw): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6><?= htmlspecialchars($rw['name']) ?></h6>
                            <p><?= nl2br(htmlspecialchars($rw['description'])) ?></p>
                            <p><b>Poin Dibutuhkan:</b> <?= $rw['points_required'] ?></p>
                            <form method="post" action="?page=membership_redeem">
                                <input type="hidden" name="reward_id" value="<?= $rw['id'] ?>">
                                <button class="btn btn-sm btn-outline-primary">Tukarkan</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h5>Referral</h5>
        <form method="post" action="?page=referral_submit">
            <div class="mb-3"><input type="email" name="referred_email" class="form-control" placeholder="Email teman">
            </div>
            <button class="btn btn-primary">Kirim Referral</button>
        </form>
    </div>
</body>

</html> -->