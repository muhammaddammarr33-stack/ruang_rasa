<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5" style="max-width:480px;">
        <h3 class="text-center mb-4">Reset Password</h3>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="post" action="?page=forgot">
            <div class="mb-3"><label>Email Anda</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Kirim Link Reset</button>
        </form>
        <div class="text-center mt-3"><a href="?page=login">Kembali ke Login</a></div>
    </div>
</body>

</html>