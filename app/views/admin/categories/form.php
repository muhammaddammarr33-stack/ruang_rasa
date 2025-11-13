<?php if (!isset($_SESSION))
    session_start(); ?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($cat) ? 'Edit' : 'Tambah' ?> Kategori – Ruang Rasa Admin</title>

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
        }

        .form-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2.25rem;
            max-width: 600px;
            margin: 2rem auto;
        }

        .form-card h3 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-card h3 i {
            color: var(--soft-blue);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-control:focus {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-primary {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #e0e0e0;
            border: none;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            color: var(--dark-grey);
            transition: background-color 0.2s;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--soft-blue);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--dark-grey);
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=admin_dashboard"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="?page=admin_categories">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= isset($cat) ? 'Edit' : 'Tambah' ?>
                </li>
            </ol>
        </nav>

        <div class="form-card">
            <h3>
                <i class="fas fa-tags"></i>
                <?= isset($cat) ? 'Edit Kategori' : 'Tambah Kategori Baru' ?>
            </h3>

            <form method="post"
                action="<?= isset($cat) ? '?page=admin_category_update' : '?page=admin_category_store' ?>">
                <?php if (isset($cat)): ?>
                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control"
                        value="<?= htmlspecialchars($cat['name'] ?? '') ?>"
                        placeholder="Contoh: Hadiah Anniversary, Surat Digital, dll." required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control"
                        placeholder="Jelaskan untuk apa kategori ini digunakan..."><?= htmlspecialchars($cat['description'] ?? '') ?></textarea>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i><?= isset($cat) ? 'Simpan Perubahan' : 'Tambah Kategori' ?>
                    </button>
                    <a href="?page=admin_categories" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript ringan (opsional) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fokus otomatis ke input nama
            const nameInput = document.querySelector('input[name="name"]');
            if (nameInput) nameInput.focus();
        });
    </script>
</body>

</html>