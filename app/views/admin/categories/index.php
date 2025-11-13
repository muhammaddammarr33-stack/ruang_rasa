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

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .admin-header h3 {
            font-weight: 700;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-header h3 i {
            color: var(--soft-blue);
        }

        .card-table {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--dark-grey);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: rgba(121, 161, 191, 0.04);
        }

        .btn-add {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            border: none;
            border-radius: 12px;
            padding: 0.7rem 1.4rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 4px 10px rgba(121, 161, 191, 0.25);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(121, 161, 191, 0.35);
        }

        .btn-edit {
            background-color: #fde047;
            border: none;
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #333;
            transition: background-color 0.2s;
        }

        .btn-edit:hover {
            background-color: #fcd32a;
        }

        .btn-delete {
            background-color: #fca5a5;
            border: none;
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #991b1b;
            transition: background-color 0.2s;
        }

        .btn-delete:hover {
            background-color: #f87171;
        }

        .alert {
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: rgba(231, 164, 148, 0.2);
            color: var(--dark-grey);
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

        /* Responsif: tumpuk aksi di mobile */
        @media (max-width: 576px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .btn-add {
                width: 100%;
            }

            .table td,
            .table th {
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            .table thead {
                display: none;
            }

            /* Stack card-style di mobile */
            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                background: white;
                border-radius: 14px;
                padding: 1rem;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.4rem 0 !important;
            }

            .table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark-grey);
            }

            .table tbody td:last-child {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .table tbody td:last-child:before {
                content: "Aksi: ";
            }
        }
    </style>
</head>

<body>
    <div class="container py-3">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=admin_dashboard"
                        style="color: var(--soft-blue); text-decoration: none;">
                        <i class="fas fa-home"></i> Dashboard
                    </a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategori</li>
            </ol>
        </nav>

        <!-- Alert -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i
                    class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']);
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

        <!-- Tabel -->
        <?php if (!empty($categories)): ?>
            <div class="card-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $c): ?>
                            <tr>
                                <td data-label="ID"><?= $c['id'] ?></td>
                                <td data-label="Nama"><?= htmlspecialchars($c['name']) ?></td>
                                <td data-label="Deskripsi"><?= htmlspecialchars($c['description'] ?: '–') ?></td>
                                <td data-label="Aksi">
                                    <a href="?page=admin_category_form&id=<?= $c['id'] ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?page=admin_category_delete&id=<?= $c['id'] ?>" class="btn btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus kategori “<?= addslashes(htmlspecialchars($c['name'])) ?>”?\n\nTindakan ini tidak bisa dibatalkan.')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5"
                style="background: white; border-radius: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-inbox fa-2x" style="color: #ccc; margin-bottom: 1rem;"></i>
                <p class="text-muted">Belum ada kategori. <a href="?page=admin_category_form"
                        style="color: var(--soft-blue);">Tambahkan sekarang?</a></p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Tidak perlu library berat — confirm native sudah cukup
        // Tapi kita pastikan pesan aman dari XSS via addslashes() di PHP
    </script>
</body>

</html>