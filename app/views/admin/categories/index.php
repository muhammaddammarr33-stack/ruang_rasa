<?php if (!isset($_SESSION))
    session_start(); ?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin – Kelola Kategori | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --accent: #7093B3;
            /* ✅ Biru pastel */
            --accent-hover: #5d7da0;
            --dark-grey: #343D46;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
        }

        body {
            background-color: #FFFFFF;
            /* ✅ Putih bersih */
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            font-size: 0.875rem;
            padding-top: 1rem;
            padding-bottom: 1.5rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .admin-header h3 {
            font-weight: 600;
            color: var(--dark-grey);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .admin-header h3 i {
            color: var(--accent);
        }

        .card-table {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            /* ✅ Lebih tajam */
            box-shadow: none;
            /* ✅ Hilangkan shadow */
            overflow: hidden;
        }



        .btn-add {
            background-color: var(--accent);
            border: 1px solid var(--accent);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: white;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }

        .btn-add:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            transform: none;
            box-shadow: none;
            color: white;
        }

        .btn-edit,
        .btn-delete {
            padding: 0.375rem 0.625rem;
            font-size: 0.8125rem;
            border-radius: 5px;
            font-weight: 500;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .btn-edit {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        .btn-edit:hover {
            background-color: #ffecb5;
        }

        .btn-delete {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .btn-delete:hover {
            background-color: #f1b0b7;
        }

        .alert {
            border-radius: 6px;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            border: 1px solid #e9ecef;
            margin-bottom: 1rem;
            background-color: #f8f9fa;
            color: var(--dark-grey);
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
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="?page=admin_dashboard">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kategori</li>
            </ol>
        </nav>

        <!-- Alert -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert">
                <i class="fas fa-check-circle me-1"></i>
                <?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="admin-header">
            <h3><i class="fas fa-tags"></i> Kelola Kategori</h3>
            <a href="?page=admin_category_form" class="btn btn-add">
                <i class="fas fa-plus me-1"></i> Tambah Kategori
            </a>
        </div>

        <!-- Tabel atau Pesan Kosong -->
        <?php if (!empty($categories)): ?>
            <div class="card-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($categories as $c): ?>
                            <tr>
                                <th data-label="No" scope="row"><?= $i++ ?></th>
                                <td data-label="Nama"><?= htmlspecialchars($c['name']) ?></td>
                                <td data-label="Deskripsi"><?= htmlspecialchars($c['description'] ?: '–') ?></td>
                                <td data-label="Aksi" class="d-flex flex-row gap-2">
                                    <a href="?page=admin_category_form&id=<?= $c['id'] ?>" class="btn btn-edit">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="?page=admin_category_delete&id=<?= $c['id'] ?>" class="btn btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus kategori “<?= addslashes(htmlspecialchars($c['name'])) ?>”?\n\nTindakan ini tidak bisa dibatalkan.')">
                                        <i class="fas fa-trash-alt me-1"></i>Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4" style="background: white; border: 1px solid #e9ecef; border-radius: 8px;">
                <i class="fas fa-inbox fa-lg" style="color: #ccc; margin-bottom: 0.75rem;"></i>
                <p class="text-muted mb-0">
                    Belum ada kategori.
                    <a href="?page=admin_category_form" style="color: var(--accent); text-decoration: none;">Tambahkan
                        sekarang?</a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
