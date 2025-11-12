<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5" style="max-width:720px;">
        <h3 class="mb-4">Profil Saya</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="post" action="?page=profile_update" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6"><label>Nama</label><input type="text" name="name" class="form-control"
                        value="<?= htmlspecialchars($user['name']) ?>"></div>
                <div class="col-md-6"><label>Email</label><input type="email" class="form-control"
                        value="<?= htmlspecialchars($user['email']) ?>" disabled></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><label>No. Telepon</label><input type="text" name="phone" class="form-control"
                        value="<?= htmlspecialchars($user['phone']) ?>"></div>
                <div class="col-md-6"><label>Foto Profil</label><input type="file" name="profile_image"
                        class="form-control"></div>
            </div>
            <div class="mb-3"><label>Alamat</label><textarea name="address"
                    class="form-control"><?= htmlspecialchars($user['address']) ?></textarea></div>
            <button class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>