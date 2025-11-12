<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Atur Ulang Password - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center mb-3">Atur Password Baru</h4>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'];
                            unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="?page=auth_reset">
                            <?= SecurityHelper::csrfInput(); ?>
                            <input type="hidden" name="token"
                                value="<?= htmlspecialchars($_GET['token'] ?? $_POST['token'] ?? '') ?>">
                            <div class="mb-3">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Ubah Password</button>
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