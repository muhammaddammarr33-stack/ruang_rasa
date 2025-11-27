<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Form Reward</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h4><?= $reward ? 'Edit' : 'Tambah' ?> Reward</h4>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="post" action="?page=<?= $reward ? 'admin_rewards_update' : 'admin_rewards_store' ?>">
            <?php if ($reward): ?>
                <input type="hidden" name="id" value="<?= $reward['id'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label>Nama</label>
                <input name="name" class="form-control" value="<?= htmlspecialchars($reward['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label>Poin yang diperlukan</label>
                <input type="number" name="points_required" class="form-control"
                    value="<?= htmlspecialchars($reward['points_required'] ?? 0) ?>" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"
                    rows="4"><?= htmlspecialchars($reward['description'] ?? '') ?></textarea>
            </div>

            <div>
                <button class="btn btn-primary"><?= $reward ? 'Update' : 'Tambah' ?></button>
                <a class="btn btn-secondary" href="?page=admin_rewards">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>