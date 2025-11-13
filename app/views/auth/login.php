<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS (digunakan ringan, mostly untuk grid) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome untuk ikon outline -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --off-white: #F5F5EC;
            --soft-blue: #79A1BF;
            --soft-peach: #E7A494;
            --dark-grey: #343D46;
        }

        body {
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            padding: 0;
            margin: 0;
        }

        .login-card {
            border-radius: 18px;
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            background: white;
            padding: 2.25rem 2rem;
            max-width: 480px;
            width: 100%;
        }

        .login-card h4 {
            font-weight: 600;
            margin-bottom: 1.25rem;
            color: var(--dark-grey);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .btn-login {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-login:hover {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .text-link {
            color: var(--soft-blue);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
        }

        .alert-danger {
            border-left: 4px solid #e74c3c;
        }

        .alert-success {
            border-left: 4px solid var(--soft-peach);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--soft-blue);
        }

        .input-icon input {
            padding-left: 2.75rem;
        }

        /* Micro-interaction: shake on error */
        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-6px);
            }

            40%,
            80% {
                transform: translateX(6px);
            }
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="login-card">
        <div class="text-center mb-3">
            <h4>Masuk ke Ruang Rasa</h4>
            <p class="text-muted" style="font-size: 0.95rem;">Kirim kejutan hangat untuk pasanganmu 💞</p>
        </div>

        <!-- PHP Alerts tetap dipertahankan -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']);
            unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" method="POST" action="?page=login">
            <?= SecurityHelper::csrfInput(); ?>

            <div class="mb-3 input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="email@kamu.com" required>
            </div>

            <div class="mb-3 input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-login w-100">Masuk</button>
        </form>

        <div class="mt-3 text-center" style="font-size: 0.95rem;">
            <a href="?page=register" class="text-link">Belum punya akun?</a> |
            <a href="?page=auth_forgot" class="text-link">Lupa password?</a>
        </div>
    </div>

    <script>
        // Validasi UX: shake animasi saat error (opsional tambahan)
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            const alerts = document.querySelectorAll('.alert');

            // Jika ada alert error, shake form
            if (document.querySelector('.alert-danger')) {
                loginForm.classList.add('shake');
            }

            // Prevent double-submit (opsional tapi baik untuk UX)
            loginForm.addEventListener('submit', function () {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memproses...';
                // Kembalikan setelah 2 detik jika gagal, atau biarkan jika redirect
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Masuk';
                }, 2000);
            });
        });
    </script>
</body>

</html>