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
            padding: 1.5rem 0;
        }

        .section-title {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            color: var(--dark-grey);
        }

        .product-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .card-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark-grey);
            margin-bottom: 0.5rem;
        }

        .category-badge {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 0.75rem;
        }

        .price-original {
            text-decoration: line-through;
            color: #888;
            font-size: 0.95rem;
        }

        .discount-badge {
            background-color: #e74c3c;
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            margin-left: 0.4rem;
            vertical-align: middle;
        }

        .price-final {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--soft-blue);
            margin: 0.5rem 0;
        }

        .btn-add {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.6rem;
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            transition: background-color 0.2s;
        }

        .btn-add:hover:not(:disabled) {
            background-color: #658db2;
        }

        .btn-detail {
            background-color: #f8f9fa;
            color: var(--soft-blue);
            border: 1px solid var(--soft-blue);
            border-radius: 10px;
            padding: 0.6rem;
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            text-decoration: none;
            display: block;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
        }

        .btn-detail:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        .btn-back-home {
            background-color: #f0f0f0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.7rem 1.25rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-back-home:hover {
            background-color: #e0e0e0;
        }

        /* Search Form */
        .search-container {
            background: white;
            padding: 1.25rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2.5rem;
        }

        .search-form .form-control,
        .search-form .form-select {
            border-radius: 12px;
            padding: 0.65rem 1rem;
            border: 1px solid #ddd;
        }

        .search-form .form-control:focus,
        .search-form .form-select:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .search-form .btn-search {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            font-weight: 600;
        }

        .search-form .btn-search:hover {
            background-color: #658db2;
        }

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                gap: 0.75rem;
            }

            .search-form .btn-search {
                width: 100%;
            }

            .section-title {
                text-align: center;
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Judul -->
        <h2 class="section-title text-center text-md-start">Semua Kado Spesial</h2>

        <!-- Pencarian -->
        <div class="search-container">
            <form class="d-flex flex-wrap gap-2" method="get" action="">
                <input type="hidden" name="page" value="products">
                <input type="text" name="search" class="form-control" placeholder="Cari kado atau pesan..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>" aria-label="Cari kado">
                <select name="category" class="form-select" aria-label="Pilih kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= (int) $cat['id'] ?>" <?= (($_GET['category'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn-search" aria-label="Cari kado">
                    <i class="fas fa-search" aria-hidden="true"></i> Cari
                </button>
            </form>
        </div>

        <!-- Produk -->
        <?php if (!empty($products)): ?>
            <div class="row g-4">
                <?php foreach ($products as $p): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="product-card">
                            <img src="uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png', ENT_QUOTES, 'UTF-8') ?>"
                                class="card-img-top" alt="<?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>"
                                onerror="this.src='https://via.placeholder.com/300x200?text=Gambar+Tidak+Tersedia'">
                            <div class="card-body">
                                <h6 class="card-title"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h6>
                                <p class="category-badge">
                                    <?= htmlspecialchars($p['category_name'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>

                                <div class="mb-2">
                                    <?php if (!empty($p['discount_percent']) && $p['discount_percent'] > 0): ?>
                                        <div class="price-original">
                                            Rp <?= number_format($p['base_price'], 0, ',', '.') ?>
                                        </div>
                                        <span class="discount-badge">Diskon <?= (int) $p['discount_percent'] ?>%</span>
                                        <div class="price-final">
                                            Rp <?= number_format($p['final_price'], 0, ',', '.') ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="price-final">
                                            Rp <?= number_format($p['final_price'], 0, ',', '.') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-auto">
                                    <a href="?page=product_detail&id=<?= (int) $p['id'] ?>" class="btn-detail"
                                        aria-label="Lihat detail <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>">
                                        <i class="fas fa-eye" aria-hidden="true"></i> Detail
                                    </a>
                                    <form method="post" action="?page=add_to_cart" class="mt-1">
                                        <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                                        <button type="submit" class="btn-add"
                                            aria-label="Tambah <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?> ke keranjang">
                                            <i class="fas fa-cart-plus" aria-hidden="true"></i> Tambah ke Keranjang
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
                <i class="fas fa-gift fa-2x text-muted mb-3" aria-hidden="true"></i>
                <p class="text-muted">Tidak ada kado yang cocok dengan pencarianmu.</p>
                <a href="?page=products" class="btn-back-home mt-2">
                    Tampilkan Semua Kado
                </a>
            </div>
        <?php endif; ?>

        <!-- Kembali ke Beranda -->
        <div class="text-center mt-5">
            <a href="?page=landing" class="btn-back-home" aria-label="Kembali ke beranda">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>