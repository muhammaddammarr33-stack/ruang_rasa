<?php // app/views/admin/products/form.php
if (!isset($_SESSION))
    session_start();
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $product ? 'Edit Produk' : 'Tambah Produk' ?> – Ruang Rasa Admin</title>

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
        }

        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            font-size: 0.875rem;
            padding-top: 1rem;
            padding-bottom: 1.5rem;
        }

        .form-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: none;
            padding: 1.25rem;
            max-width: 780px;
            margin: 1rem auto;
        }

        .form-card h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
            font-size: 1.25rem;
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
            color: var(--dark);
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border);
            font-size: 0.875rem;
        }

        .form-control:focus,
        .form-select:focus {
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
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            transform: none;
            box-shadow: none;
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        .btn-link-danger {
            color: var(--danger);
            font-size: 0.8125rem;
            padding: 0.25rem;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-link-danger:hover {
            color: #c82333;
            text-decoration: underline;
        }

        .image-preview {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .image-preview img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            display: block;
        }

        .alert {
            border-radius: 6px;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            border: 1px solid #f8d7da;
            background-color: #f8f9fa;
            color: var(--dark);
        }

        .alert-danger {
            background-color: #f8f9fa;
            border-left: 3px solid var(--danger);
            color: var(--danger);
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

        .input-section {
            margin-bottom: 1rem;
        }

        .gallery-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .preview-img {
            max-height: 140px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid var(--border);
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
                <li class="breadcrumb-item">
                    <a href="?page=admin_products">Produk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $product ? 'Edit' : 'Tambah' ?>
                </li>
            </ol>
        </nav>

        <div class="form-card">
            <h3>
                <i class="fas fa-gift"></i>
                <?= $product ? 'Edit Produk' : 'Tambah Produk Baru' ?>
            </h3>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <?= htmlspecialchars($_SESSION['error']);
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= $product ? '?page=admin_product_update' : '?page=admin_product_store' ?>"
                enctype="multipart/form-data">

                <?php if ($product): ?>
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <?php endif; ?>

                <!-- Nama Produk -->
                <div class="input-section">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control"
                        value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                        placeholder="Contoh: Surat Cinta Digital, Paket Anniversary, dll." required>
                </div>

                <!-- Deskripsi -->
                <div class="input-section">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control"
                        placeholder="Jelaskan produk ini secara hangat dan personal..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>

                <!-- Harga, Stok, Kategori -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" step="100" min="0"
                            value="<?= $product['price'] ?? 0 ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" min="0"
                            value="<?= $product['stock'] ?? 0 ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= (isset($product['category_id']) && $product['category_id'] == $c['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Gambar Utama -->
                <div class="input-section">
                    <label class="form-label">Gambar Utama (jpg/png, maks 2MB)</label>
                    <?php if (!empty($product['image'])): ?>
                        <div class="mb-2">
                            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Gambar utama"
                                class="preview-img">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png">
                </div>

                <!-- Gallery -->
                <div class="input-section">
                    <div class="gallery-label">
                        <label class="form-label mb-0">Gallery Tambahan (opsional)</label>
                        <i class="fas fa-info-circle text-muted" title="Pilih beberapa file sekaligus"></i>
                    </div>
                    <input type="file" name="gallery[]" multiple class="form-control" accept="image/jpeg,image/png">

                    <?php if ($product):
                        $productModel = new Product();
                        $imgs = $productModel->getImages($product['id']);
                        if (!empty($imgs)): ?>
                            <div class="mt-2">
                                <p class="form-label mb-1">Gambar saat ini:</p>
                                <div>
                                    <?php foreach ($imgs as $img): ?>
                                        <div class="image-preview">
                                            <img src="public/uploads/<?= htmlspecialchars($img['image_path']) ?>" alt="Gallery">
                                            <a href="?page=admin_product_delete_image&img_id=<?= $img['id'] ?>&product_id=<?= $product['id'] ?>"
                                                class="btn-link-danger" onclick="return confirm('Hapus gambar ini?')">
                                                Hapus
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i><?= $product ? 'Simpan' : 'Tambah Produk' ?>
                    </button>
                    <a href="?page=admin_products" class="btn btn-secondary">
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