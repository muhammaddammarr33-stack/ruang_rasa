<?php // app/views/admin/product_form.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="?page=admin_products" class="btn btn-link">← Kembali</a>
        <h3>Tambah Produk</h3>
        <form method="post" action="?page=admin_products" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Kategori</label>
                <select name="category_id" class="form-select" required>
                    <option value="">--Pilih Kategori--</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Diskon (%)</label>
                    <input type="number" name="discount" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control">
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="featured" class="form-check-input" id="featured">
                <label class="form-check-label" for="featured">Tampilkan di halaman utama</label>
            </div>
            <div class="mb-3">
                <label>Upload Gambar (jpg/png, max 2MB)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
            <button class="btn btn-primary">Simpan Produk</button>
        </form>
    </div>
</body>

</html>