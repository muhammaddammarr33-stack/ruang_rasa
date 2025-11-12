<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Lupa Password - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center mb-3">Reset Password</h4>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'];
                            unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="?page=auth_forgot">
                            <?= SecurityHelper::csrfInput(); ?>
                            <div class="mb-3">
                                <label>Masukkan Email Anda</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="?page=login">Kembali ke Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>