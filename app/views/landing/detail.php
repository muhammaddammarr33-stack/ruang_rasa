<?php // app/views/landing/detail.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?> – Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        .product-detail-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .main-image {
            width: 100%;
            height: 420px;
            object-fit: contain;
            padding: 2rem;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail {
            width: 76px;
            height: 76px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--soft-blue);
            transform: scale(1.03);
        }

        .product-title {
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--dark-grey);
            margin-bottom: 0.75rem;
        }

        .price-display {
            margin-bottom: 1.25rem;
        }

        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 1.1rem;
        }

        .discount-badge {
            background-color: #e74c3c;
            color: white;
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            margin-left: 0.5rem;
            vertical-align: middle;
        }

        .final-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--soft-blue);
        }

        .stock-available {
            color: var(--soft-peach);
            font-weight: 600;
        }

        .stock-unavailable {
            color: #e74c3c;
            font-weight: 600;
        }

        .btn-cart {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1.05rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-cart:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-customize {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            width: 100%;
            margin-top: 0.75rem;
            box-shadow: 0 4px 10px rgba(121, 161, 191, 0.25);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-customize:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(121, 161, 191, 0.35);
        }

        .btn-disabled {
            background-color: #e0e0e0;
            color: #999;
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            width: 100%;
            cursor: not-allowed;
        }

        .qty-input {
            border-radius: 12px;
            padding: 0.65rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
            width: 100%;
        }

        .qty-input:focus {
            border-color: var(--soft-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
        }

        .description {
            line-height: 1.65;
            color: var(--dark-grey);
            opacity: 0.95;
            margin-bottom: 1.5rem;
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

        @media (max-width: 768px) {
            .main-image {
                height: 320px;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .final-price {
                font-size: 1.35rem;
            }

            .btn-cart,
            .btn-customize,
            .btn-disabled {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=landing">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>
                </li>
            </ol>
        </nav>

        <div class="product-detail-card">
            <div class="row g-0">
                <!-- Gambar Produk -->
                <div class="col-md-6 p-4 text-center">
                    <?php if (!empty($images)): ?>
                        <img id="mainImage"
                            src="uploads/<?= htmlspecialchars($images[0]['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                            class="main-image" alt="<?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>" role="img"
                            aria-label="Gambar utama <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>">
                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <?php foreach ($images as $index => $img): ?>
                                <img src="uploads/<?= htmlspecialchars($img['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="thumbnail <?= $index === 0 ? 'active' : '' ?>"
                                    data-src="uploads/<?= htmlspecialchars($img['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Gambar <?= $index + 1 ?> dari <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>"
                                    tabindex="0">
                            <?php endforeach; ?>
                        </div>
                    <?php elseif (!empty($p['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($p['image'], ENT_QUOTES, 'UTF-8') ?>" class="main-image"
                            alt="<?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php else: ?>
                        <div class="main-image d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-box-open" style="font-size: 3rem;" aria-hidden="true"></i>
                            <span class="visually-hidden">Produk tanpa gambar</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Info Produk -->
                <div class="col-md-6 p-4">
                    <h1 class="product-title"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h1>

                    <div class="price-display">
                        <?php if (!empty($p['discount_percent']) && $p['discount_percent'] > 0): ?>
                            <div class="original-price">
                                Rp <?= number_format($p['base_price'], 0, ',', '.') ?>
                            </div>
                            <span class="discount-badge">-<?= (int) $p['discount_percent'] ?>%</span>
                            <div class="final-price mt-1">
                                Rp <?= number_format($p['final_price'], 0, ',', '.') ?>
                            </div>
                        <?php else: ?>
                            <div class="final-price">
                                Rp <?= number_format($p['final_price'], 0, ',', '.') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($p['stock'] > 0): ?>
                        <p class="stock-available">
                            <i class="fas fa-check-circle" aria-hidden="true"></i> Tersedia (<?= (int) $p['stock'] ?> stok)
                        </p>
                    <?php else: ?>
                        <p class="stock-unavailable">
                            <i class="fas fa-times-circle" aria-hidden="true"></i> Stok habis
                        </p>
                    <?php endif; ?>

                    <p class="description"><?= nl2br(htmlspecialchars($p['description'], ENT_QUOTES, 'UTF-8')) ?></p>

                    <?php if ($p['stock'] > 0): ?>
                        <form method="post" action="?page=add_to_cart" novalidate>
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">

                            <div class="mb-3">
                                <label for="qty" class="form-label fw-medium">Jumlah</label>
                                <input type="number" id="qty" name="qty" value="1" min="1" max="<?= (int) $p['stock'] ?>"
                                    class="qty-input" aria-label="Jumlah produk yang ingin dibeli">
                            </div>

                            <button type="submit" class="btn-cart"
                                aria-label="Tambah <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?> ke keranjang">
                                <i class="fas fa-shopping-cart me-2" aria-hidden="true"></i>Tambah ke Keranjang
                            </button>
                        </form>

                    <?php else: ?>
                        <button class="btn-disabled" disabled>
                            <i class="fas fa-ban me-2" aria-hidden="true"></i> Tidak Tersedia
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail');

            if (mainImage && thumbnails.length > 0) {
                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', function () {
                        thumbnails.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        mainImage.src = this.getAttribute('data-src');
                    });

                    // Dukungan keyboard (Enter/Space)
                    thumb.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    });
                });
            }

            const qtyInput = document.getElementById('qty');
            if (qtyInput) {
                const maxStock = <?= (int) $p['stock'] ?>;
                qtyInput.addEventListener('input', function () {
                    let value = parseInt(this.value);
                    if (isNaN(value) || value < 1) this.value = 1;
                    if (value > maxStock) this.value = maxStock;
                });
            }
        });
    </script>
</body>

</html>