<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - Ruang Rasa</title>

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
            --dark-grey: #343D46;
        }

        body {
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            padding: 0;
            margin: 0;
        }

        .verify-card {
            max-width: 500px;
            margin: 2.5rem auto;
            text-align: center;
            padding: 2.5rem 2rem;
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .verify-card h3 {
            font-weight: 600;
            margin-bottom: 1.25rem;
            color: var(--dark-grey);
        }

        .verify-card p {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--dark-grey);
            opacity: 0.9;
        }

        .icon-email {
            font-size: 2.5rem;
            color: var(--soft-blue);
            margin-bottom: 1.5rem;
        }

        .btn-back {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 1rem;
        }

        .btn-back:hover {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .text-muted {
            font-size: 0.9rem;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="verify-card">
        <div class="icon-email">
            <i class="fas fa-paper-plane"></i>
        </div>
        <h3>Periksa Emailmu 💬</h3>
        <p>
            Kami telah mengirimkan link verifikasi ke kotak masukmu.<br>
            Jangan lupa cek folder <strong>Spam</strong> atau <strong>Promosi</strong> ya!
        </p>
        <p class="text-muted">
            Setelah verifikasi, kamu bisa mulai mengirim kejutan hangat untuk pasanganmu dari jarak jauh.
        </p>
        <a href="?page=login" class="btn btn-back mt-3">Kembali ke Login</a>
    </div>
</body>

</html>