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
            max-width: 800px;
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
        .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }

        .form-control:focus,
        .form-select:focus {
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

        .btn-link-danger {
            color: #e74c3c;
            font-size: 0.85rem;
            padding: 0.25rem;
            text-decoration: none;
        }

        .btn-link-danger:hover {
            color: #c0392b;
            text-decoration: underline;
        }

        .image-preview {
            display: inline-block;
            margin-right: 12px;
            margin-bottom: 12px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .image-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            display: block;
        }

        .alert {
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #ffecec;
            border-left: 4px solid #e74c3c;
            color: #c0392b;
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

        .input-section {
            margin-bottom: 1.5rem;
        }

        .gallery-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
                <li class="breadcrumb-item"><a href="?page=admin_products" style="color: var(--soft-blue);">Produk</a>
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
                    <i
                        class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']);
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
                <div class="row mb-4">
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
                                style="max-height: 150px; object-fit: contain; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
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
                            <div class="mt-3">
                                <p class="form-label mb-2">Gambar saat ini:</p>
                                <div>
                                    <?php foreach ($imgs as $img): ?>
                                        <div class="image-preview">
                                            <img src="public/uploads/<?= htmlspecialchars($img['image_path']) ?>" alt="Gallery">
                                            <a href="?page=admin_product_delete_image&img_id=<?= $img['id'] ?>&product_id=<?= $product['id'] ?>"
                                                class="btn btn-link-danger d-block text-center"
                                                onclick="return confirm('Hapus gambar ini?')">
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
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i><?= $product ? 'Simpan Perubahan' : 'Tambah Produk' ?>
                    </button>
                    <a href="?page=admin_products" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fokus ke input nama saat halaman terbuka
            const nameInput = document.querySelector('input[name="name"]');
            if (nameInput) nameInput.focus();
        });
    </script>
</body>

</html>