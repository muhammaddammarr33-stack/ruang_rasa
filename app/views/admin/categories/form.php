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
            --accent: #7093B3;
            /* ✅ Biru pastel sesuai preferensi */
            --accent-hover: #5d7da0;
            --dark-grey: #343D46;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
        }

        body {
            background-color: #FFFFFF;
            /* ✅ Putih bersih */
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            font-size: 0.875rem;
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        .form-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            /* ✅ Lebih tajam */
            box-shadow: none;
            /* ✅ Hilangkan shadow berlebih */
            padding: 1.25rem;
            /* ✅ Lebih kecil dari 2.25rem */
            max-width: 580px;
            margin: 1rem auto;
        }

        .form-card h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-grey);
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .form-card h3 i {
            color: var(--accent);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.375rem;
            font-size: 0.875rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-control:focus {
            border-radius: 6px;
            /* ✅ Lebih kecil */
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(112, 147, 179, 0.15);
            outline: none;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--accent);
            border: 1px solid var(--accent);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--dark-grey);
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
            font-size: 0.8125rem;
        }

        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }
    </style>
</head>

<body>
    <div class="container">
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

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control"
                        value="<?= htmlspecialchars($cat['name'] ?? '') ?>"
                        placeholder="Contoh: Hadiah Anniversary, Surat Digital, dll." required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi (Opsional)</label>
                    <textarea name="description" class="form-control"
                        placeholder="Jelaskan untuk apa kategori ini digunakan..."><?= htmlspecialchars($cat['description'] ?? '') ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i><?= isset($cat) ? 'Simpan' : 'Tambah' ?>
                    </button>
                    <a href="?page=admin_categories" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.querySelector('input[name="name"]');
            if (nameInput) nameInput.focus();
        });
    </script>
</body>

</html>