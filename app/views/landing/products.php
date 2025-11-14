<?php // app/views/landing/products.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Kado | Ruang Rasa</title>

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

        .section-title {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
        }

        .product-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--dark-grey);
        }

        .price {
            color: var(--soft-blue);
            font-weight: 700;
            font-size: 1.15rem;
        }

        .btn-primary {
            background-color: var(--soft-blue);
            border: none;
        }

        .btn-primary:hover {
            background-color: #658db2;
        }

        .btn-outline-primary {
            color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-outline-primary:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        .search-form .form-control,
        .search-form .form-select {
            border-radius: 12px;
            padding: 0.65rem 1rem;
        }

        .search-form .btn {
            border-radius: 12px;
            padding: 0.65rem 1.2rem;
        }

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                gap: 0.75rem;
            }

            .search-form .btn {
                align-self: stretch;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <!-- 🔹 Judul & Pencarian -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
            <h2 class="section-title">Semua Kado Spesial</h2>

            <form class="d-flex search-form flex-wrap gap-2" method="get" action="">
                <input type="hidden" name="page" value="products">
                <input type="text" name="search" class="form-control" placeholder="Cari kado atau pesan..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (($_GET['category'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>

        <!-- 🔹 Daftar Produk -->
        <?php if (!empty($products)): ?>
            <div class="row g-4">
                <?php foreach ($products as $p): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card product-card h-100">
                            <img src="uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png') ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($p['name']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
                                <p class="text-muted small mb-2"><?= htmlspecialchars($p['category_name'] ?? '-') ?></p>
                                <p class="price mb-3">
                                    <?php if (!empty($p['discount_percent']) && $p['discount_percent'] > 0): ?>
                                        <span class="text-muted text-decoration-line-through">
                                            Rp <?= number_format($p['base_price'], 0, ',', '.') ?>
                                        </span>
                                        <span class="badge bg-danger ms-1">Diskon <?= $p['discount_percent'] ?>%</span><br>
                                        <strong>Rp <?= number_format($p['final_price'], 0, ',', '.') ?></strong>
                                    <?php else: ?>
                                        <strong>Rp <?= number_format($p['final_price'], 0, ',', '.') ?></strong>
                                    <?php endif; ?>
                                </p>
                                <div class="mt-auto">
                                    <a href="?page=product_detail&id=<?= $p['id'] ?>"
                                        class="btn btn-outline-primary btn-sm w-100 mb-2">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <form method="post" action="?page=add_to_cart" class="mt-1">
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-gift fa-2x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada kado yang cocok dengan pencarianmu.</p>
                <a href="?page=products" class="btn btn-outline-primary mt-2">Tampilkan Semua Kado</a>
            </div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="?page=landing" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>