<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center mb-3">Login Akun</h4>

                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'];
                            unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?= $_SESSION['success'];
                            unset($_SESSION['success']); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="?page=login">
                            <?= SecurityHelper::csrfInput(); ?>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Masuk</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="?page=register">Belum punya akun?</a> |
                            <a href="?page=auth_forgot">Lupa password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>