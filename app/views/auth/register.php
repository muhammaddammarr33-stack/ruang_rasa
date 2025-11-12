<?php // app/views/auth/register.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Ruang Rasa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/ruang-rasa.css">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Buat Akun Baru 💕</h1>
            <p class="subtitle">Mulai petualangan mengirim hadiah penuh makna</p>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="?page=register">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn-primary">Daftar Sekarang</button>
            </form>

            <div class="divider"></div>

            <p class="text-center">
                <a href="?page=login" class="link back-link">
                    ← Sudah punya akun? Masuk di sini
                </a>
            </p>

        </div>
    </div>

    <script src="<?= BASE_URL ?>/public/assets/js/ruang-rasa.js"></script>
</body>

</html>