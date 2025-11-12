<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Registrasi - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center mb-3">Buat Akun Baru</h4>

                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'];
                            unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="?page=register">
                            <?= SecurityHelper::csrfInput(); ?>
                            <div class="mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label>No. Telepon</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Daftar Sekarang</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="?page=login">Sudah punya akun? Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>