<?php
require_once __DIR__ . '/../../models/Memberships.php';
$ms = new Memberships();
$membership = $ms->get($_SESSION['user']['id']);
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Profil Saya - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h3>Profil Pengguna</h3>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="POST" action="?page=profile_update" enctype="multipart/form-data" class="mt-3">
            <?= SecurityHelper::csrfInput(); ?>
            <div class="row mb-3">
                <div class="col-md-3">
                    <?php if (!empty($user['profile_image'])): ?>
                        <img src="<?= htmlspecialchars($user['profile_image']); ?>" class="img-fluid rounded"
                            alt="Foto Profil">
                    <?php else: ?>
                        <div class="border rounded p-3 text-center text-muted">Tidak ada foto</div>
                    <?php endif; ?>
                    <input type="file" name="profile_image" class="form-control mt-2">
                </div>
                <div class="card p-3 mb-3">
                    <h5>Membership</h5>
                    <p>Tier: <strong><?= strtoupper($membership['tier']) ?></strong></p>
                    <p>Poin: <strong><?= number_format($membership['points']) ?></strong></p>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email (tidak dapat diubah)</label>
                        <input type="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="address"
                            class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="?page=logout" class="btn btn-outline-danger">Logout</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>