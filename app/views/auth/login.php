<?php
require_once __DIR__ . "/../../../config/database.php";
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Ruang Rasa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/ruang-rasa.css">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Halo, Kembali Lagi 💙</h1>
            <p class="subtitle">Masuk untuk lanjutkan mengirim kejutan penuh rasa</p>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="?page=login">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn-primary">Masuk ke Ruang Rasa</button>
            </form>

            <div class="divider"></div>

            <p class="text-center">
                Belum punya akun?
                <a href="?page=register" class="link">Daftar Sekarang</a>
            </p>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/ruang-rasa.js"></script>
</body>

</html>