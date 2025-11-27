<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Password - Ruang Rasa</title>

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

        .reset-new-card {
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            background: white;
            padding: 2.25rem 2rem;
            max-width: 480px;
            width: 100%;
        }

        .reset-new-card h1 {
            font-weight: 600;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .reset-new-card .subtitle {
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

        .input-icon input {
            padding-left: 2.75rem;
        }

        .form-text {
            font-size: 0.85rem;
            color: #777;
            margin-top: 0.25rem;
            margin-left: 2.75rem;
            /* Selaras dengan teks input */
        }

        .btn-update {
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

        .btn-update:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-update:disabled {
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
        <div class="reset-new-card mx-auto">
            <div class="text-center mb-3">
                <h1>Atur Password Baru</h1>
                <p class="subtitle">Buat sandi baru agar kamu bisa kembali mengirim kejutan untuk pasanganmu 💞</p>
            </div>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert" aria-live="polite">
                    <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form id="resetNewForm" method="POST" action="?page=auth_reset" novalidate>
                <?= SecurityHelper::csrfInput(); ?>
                <input type="hidden" name="token"
                    value="<?= htmlspecialchars($_GET['token'] ?? $_POST['token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <div class="input-icon">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter"
                        required minlength="6" autocomplete="new-password" aria-label="Password baru">
                    <div class="form-text">Gunakan kombinasi huruf & angka untuk keamanan lebih baik</div>
                </div>

                <button type="submit" class="btn-update" id="updateButton">Ubah Password</button>
            </form>

            <div class="mt-4 text-center">
                <a href="?page=login" class="text-link">← Kembali ke Login</a>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('resetNewForm');
            const passwordInput = document.querySelector('input[name="password"]');
            const updateButton = document.getElementById('updateButton');

            // Shake & fokus jika ada error
            if (document.querySelector('.alert-danger')) {
                form.classList.add('shake');
                if (passwordInput) passwordInput.focus();
            }

            // Cegah double-submit
            if (form && updateButton) {
                form.addEventListener('submit', function (e) {
                    if (updateButton.disabled) {
                        e.preventDefault();
                        return;
                    }
                    updateButton.disabled = true;
                    updateButton.textContent = 'Mengubah...';
                });
            }

            // Validasi real-time password
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