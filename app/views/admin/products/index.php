<?php // app/views/admin/products/index.php
if (!isset($_SESSION))
    session_start();
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin – Kelola Produk | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --accent: #7093B3;
            --accent-hover: #5d7da0;
            --dark: #343D46;
            --muted: #6c757d;
            --border: #e9ecef;
            --danger: #dc3545;
            --warning: #e74c3c;
        }

        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
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
            color: var(--dark);
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
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: none;
            overflow: hidden;
        }

        .table thead th {
            background-color: #fafafa;
            font-weight: 600;
            color: var(--dark);
            padding: 0.75rem 1rem;
            font-size: 0.8125rem;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .product-image {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background-color: rgba(112, 147, 179, 0.05);
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
        }

        .btn-edit,
        .btn-delete {
            padding: 0.375rem 0.625rem;
            font-size: 0.8125rem;
            border-radius: 5px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
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
            margin-bottom: 1rem;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .alert-success {
            background-color: #f8f9fa;
            border-color: #d1e7dd;
            color: #0f5132;
        }

        .alert-danger {
            background-color: #f8f9fa;
            border-color: #f5c6cb;
            color: #721c24;
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
            color: var(--muted);
        }

        .stock-low {
            color: var(--warning);
            font-weight: 600;
        }

        .stock-normal {
            color: var(--accent);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .admin-header {
                align-items: stretch;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 0.75rem;
                background: white;
                border: 1px solid var(--border);
                border-radius: 6px;
                padding: 0.75rem;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.375rem 0 !important;
                border: none;
            }

            .table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark);
                min-width: 35%;
            }

            .table tbody td:last-child {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-start;
                flex-wrap: wrap;
                padding-top: 0.75rem !important;
            }

            .table tbody td:last-child:before {
                content: "Aksi:";
                min-width: auto;
            }

            .product-image {
                width: 48px;
                height: 48px;
            }
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
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>

        <!-- Alert -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <?= htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="admin-header">
            <h3><i class="fas fa-gift"></i> Kelola Produk</h3>
            <a href="?page=admin_product_form" class="btn btn-add">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>

        <!-- Tabel Produk -->
        <?php if (!empty($products)): ?>
            <div class="card-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td data-label="ID"><?= $p['id'] ?></td>
                                <td data-label="Nama"><?= htmlspecialchars($p['name']) ?></td>
                                <td data-label="Harga">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                                <td data-label="Stok" class="<?= $p['stock'] <= 5 ? 'stock-low' : 'stock-normal' ?>">
                                    <?= $p['stock'] ?>
                                    <?php if ($p['stock'] <= 5 && $p['stock'] > 0): ?>
                                        <i class="fas fa-exclamation-circle ms-1" title="Stok menipis"></i>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Kategori"><?= htmlspecialchars($p['category_name'] ?: '–') ?></td>
                                <td data-label="Gambar">
                                    <?php if ($p['image']): ?>
                                        <img src="uploads/<?= htmlspecialchars($p['image']) ?>"
                                            alt="<?= htmlspecialchars($p['name']) ?>" class="product-image">
                                    <?php else: ?>
                                        <i class="fas fa-box text-muted" style="font-size: 1.1rem;"></i>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Aksi">
                                    <a href="?page=admin_product_form&id=<?= $p['id'] ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?page=admin_product_delete&id=<?= $p['id'] ?>" class="btn btn-delete"
                                        onclick="return confirm('Yakin hapus produk “<?= addslashes(htmlspecialchars($p['name'])) ?>”?\n\nTindakan ini tidak bisa dibatalkan.')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4" style="background: white; border: 1px solid var(--border); border-radius: 8px;">
                <i class="fas fa-gift fa-lg" style="color: #ccc; margin-bottom: 0.75rem;"></i>
                <p class="text-muted mb-0">
                    Belum ada produk.
                    <a href="?page=admin_product_form" style="color: var(--accent); font-weight: 500;">Tambahkan
                        sekarang?</a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>