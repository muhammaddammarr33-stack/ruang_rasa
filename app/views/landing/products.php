<?php // app/views/landing/products.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Semua Kado | Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fafafa;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .product-card {
            transition: all .2s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .price {
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <!-- 🔹 Judul & Search -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <h2 class="section-title mb-3 mb-md-0">Semua Kado</h2>

            <form class="d-flex" method="get" action="">
                <input type="hidden" name="page" value="products">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <select name="category" class="form-select me-2">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (($_GET['category'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <!-- 🔹 Daftar Produk -->
        <?php if (!empty($products)): ?>
            <div class="row">
                <?php foreach ($products as $p): ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card product-card h-100">
                            <img src="uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png') ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($p['name']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title mb-1"><?= htmlspecialchars($p['name']) ?></h6>
                                <p class="text-muted small mb-1"><?= htmlspecialchars($p['category_name'] ?? '-') ?></p>
                                <p class="price mb-2">
                                    <?php if (!empty($p['discount_percent']) && $p['discount_percent'] > 0): ?>
                                        <span class="text-muted text-decoration-line-through">
                                            Rp <?= number_format($p['base_price'], 0, ',', '.') ?>
                                        </span>
                                        <span class="badge bg-danger ms-1">-<?= $p['discount_percent'] ?>%</span><br>
                                        <span class="fw-bold text-primary fs-6">
                                            Rp <?= number_format($p['final_price'], 0, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="fw-bold text-primary fs-6">
                                            Rp <?= number_format($p['final_price'], 0, ',', '.') ?>
                                        </span>
                                    <?php endif; ?>
                                </p>
                                <div class="mt-auto">
                                    <a href="?page=product_detail&id=<?= $p['id'] ?>"
                                        class="btn btn-outline-primary btn-sm w-100 mb-1">Lihat</a>
                                    <form method="post" action="?page=add_to_cart">
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
            <div class="alert alert-light text-center">
                <p class="text-muted mb-0">Tidak ada produk ditemukan.</p>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="?page=landing" class="btn btn-outline-secondary">⬅️ Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>