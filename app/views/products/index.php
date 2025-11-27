<?php // app/views/products/index.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Semua Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Semua Kado</h2>
            <a href="?page=landing" class="btn btn-secondary">⬅️ Kembali</a>
        </div>

        <!-- 🔍 Search dan Filter -->
        <form method="get" class="row g-3 mb-4">
            <input type="hidden" name="page" value="products">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (($_GET['category'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
            </div>
        </form>

        <!-- 🛍️ List Produk -->
        <?php if (!empty($products)): ?>
            <div class="row">
                <?php foreach ($products as $p): ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100">
                            <img src="uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png') ?>" class="card-img-top"
                                style="height: 180px; object-fit: cover;" alt="<?= htmlspecialchars($p['name']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
                                <p class="text-muted small mb-1"><?= htmlspecialchars($p['category_name'] ?? '-') ?></p>
                                <p class="fw-bold mb-2">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
                                <div class="mt-auto">
                                    <a href="?page=product_detail&id=<?= $p['id'] ?>"
                                        class="btn btn-outline-primary btn-sm w-100 mb-1">Lihat</a>
                                    <form method="post" action="?page=add_to_cart" class="mt-1">
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">+ Keranjang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Tidak ada produk ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

</html>