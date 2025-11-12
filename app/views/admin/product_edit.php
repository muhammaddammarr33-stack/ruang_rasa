<?php // app/views/admin/product_edit.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="?page=admin_products" class="btn btn-link">← Kembali</a>
        <h3>Edit Produk</h3>
        <form method="post" action="?page=admin_product_edit" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <div class="mb-3">
                <label>Kategori</label>
                <select name="category_id" class="form-select">
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= ($c['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control"
                    required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"
                    rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Harga</label>
                    <input type="number" name="price" value="<?= $product['price'] ?>" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Diskon</label>
                    <input type="number" name="discount" value="<?= $product['discount'] ?>" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Stok</label>
                    <input type="number" name="stock" value="<?= $product['stock'] ?>" class="form-control">
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="featured" class="form-check-input" <?= $product['featured'] ? 'checked' : ''; ?>>
                <label class="form-check-label">Featured</label>
            </div>
            <div class="mb-3">
                <label>Gambar Baru (Opsional)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
            <button class="btn btn-primary">Update Produk</button>
        </form>
    </div>
</body>

</html>