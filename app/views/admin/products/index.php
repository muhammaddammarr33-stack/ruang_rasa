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
            white-space: nowrap;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: rgba(231, 164, 148, 0.2);
            color: var(--dark-grey);
        }

        .alert-danger {
            background-color: rgba(248, 181, 181, 0.2);
            color: #991b1b;
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

        .stock-low {
            color: #e74c3c;
            font-weight: 600;
        }

        .stock-normal {
            color: var(--soft-blue);
        }

        /* Responsif: tumpuk di mobile */
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .btn-add {
                width: 100%;
            }

            .table thead {
                display: none;
            }

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
                padding: 0.5rem 0 !important;
                border: none;
            }

            .table tbody td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark-grey);
                flex: 0 0 120px;
            }

            .table tbody td:last-child {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-start;
                flex-wrap: wrap;
                padding-top: 1rem !important;
            }

            .table tbody td:last-child:before {
                content: "Aksi: ";
                align-self: flex-start;
            }

            .product-image {
                width: 50px;
                height: 50px;
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
                <i class="fas fa-plus me-1"></i> Tambah Produk
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
                                        <i class="fas fa-box text-muted" style="font-size: 1.2rem;"></i>
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
            <div class="text-center py-5"
                style="background: white; border-radius: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-gift fa-2x" style="color: #ccc; margin-bottom: 1rem;"></i>
                <p class="text-muted">
                    Belum ada produk.
                    <a href="?page=admin_product_form" style="color: var(--soft-blue); font-weight: 500;">Tambahkan
                        sekarang?</a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>