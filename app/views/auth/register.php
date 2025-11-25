<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
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
            padding: 1rem 0;
        }

        @media (min-height: 600px) {
            body {
                padding: 0;
                min-height: 100vh;
            }
        }

        .register-card {
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            background: white;
            padding: 2.25rem 2rem;
            max-width: 500px;
            width: 100%;
        }

        .register-card h1 {
            font-weight: 600;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .register-card .subtitle {
            font-size: 1rem;
            color: var(--dark-grey);
            opacity: 0.85;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .input-icon {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--soft-blue);
            pointer-events: none;
        }

        .input-icon input,
        .input-icon textarea {
            padding-left: 2.75rem;
        }

        .form-text {
            font-size: 0.85rem;
            color: #777;
            margin-top: 0.25rem;
            margin-left: 2.75rem;
            /* Selaras dengan input */
        }

        .btn-register {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-register:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-register:disabled {
            opacity: 0.85;
            cursor: not-allowed;
            transform: none;
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
            margin-bottom: 1.25rem;
            position: relative;
        }

        .alert-danger {
            border-left: 4px solid #e74c3c;
        }

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
    <main class="w-100">
        <div class="register-card mx-auto">
            <div class="text-center mb-3">
                <h1>Buat Akun Ruang Rasa</h1>
                <p class="subtitle">Mulai kirim kejutan hangat untuk pasanganmu dari jarak jauh 💖</p>
            </div>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert" aria-live="polite">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form id="registerForm" method="POST" action="?page=register" novalidate>
                <?= SecurityHelper::csrfInput(); ?>

                <div class="input-icon">
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nama lengkapmu" required
                        autocomplete="name" aria-label="Nama lengkap">
                </div>

                <div class="input-icon">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" name="email" class="form-control" placeholder="email@kamu.com" required
                        autocomplete="email" aria-label="Alamat email">
                </div>

                <div class="input-icon">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter"
                        required minlength="6" autocomplete="new-password" aria-label="Kata sandi">
                </div>

                <div class="input-icon">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <input type="tel" name="phone" class="form-control" placeholder="Nomor WhatsApp (opsional)"
                        autocomplete="tel" aria-label="Nomor WhatsApp (opsional)">
                    <div class="form-text">Kami hanya akan menghubungimu jika perlu konfirmasi pesanan</div>
                </div>

                <div class="input-icon">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    <textarea name="address" class="form-control" placeholder="Alamat pengiriman (opsional)"
                        autocomplete="shipping street-address" aria-label="Alamat pengiriman (opsional)"></textarea>
                    <div class="form-text">Alamat bisa diisi nanti saat pesan hadiah</div>
                </div>

                <button type="submit" class="btn-register" id="registerButton">Daftar Sekarang</button>
            </form>

            <div class="mt-4 text-center">
                <a href="?page=login" class="text-link">Sudah punya akun? Masuk</a>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registerForm');
            const nameInput = document.querySelector('input[name="name"]');
            const registerButton = document.getElementById('registerButton');

            // Shake & fokus jika ada error
            if (document.querySelector('.alert-danger')) {
                form.classList.add('shake');
                if (nameInput) nameInput.focus();
            }

            // Cegah double-submit
            if (form && registerButton) {
                form.addEventListener('submit', function (e) {
                    if (registerButton.disabled) {
                        e.preventDefault();
                        return;
                    }
                    registerButton.disabled = true;
                    registerButton.textContent = 'Mendaftar...';
                });
            }

            // Validasi password real-time
            const passwordInput = document.querySelector('input[name="password"]');
            if (passwordInput) {
                passwordInput.addEventListener('input', function () {
                    if (this.value && this.value.length < 6) {
                        this.setCustomValidity('Password minimal 6 karakter');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });
    </script>
</body>

</html>