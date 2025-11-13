<?php // app/views/landing/detail.php ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($p['name']) ?> – Ruang Rasa</title>

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
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.2s;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--soft-blue);
        }

        .product-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--dark-grey);
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--soft-blue);
            margin-bottom: 1rem;
        }

        .stock-info {
            font-size: 0.95rem;
            color: var(--soft-peach);
            font-weight: 500;
            margin-bottom: 1.2rem;
        }

        .btn-cart {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            width: 100%;
            font-size: 1.05rem;
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn-cart:hover {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-customize {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            width: 100%;
            color: white;
            margin-top: 0.75rem;
            box-shadow: 0 4px 10px rgba(121, 161, 191, 0.25);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-customize:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(121, 161, 191, 0.35);
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
        }

        .section-title {
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--dark-grey);
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=landing"
                        style="color: var(--soft-blue); text-decoration: none;">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($p['name']) ?></li>
            </ol>
        </nav>

        <div class="product-detail-card">
            <div class="row g-0">
                <!-- Gambar Produk -->
                <div class="col-md-6 p-4 text-center">
                    <?php if (!empty($images)): ?>
                        <img id="mainImage" src="uploads/<?= htmlspecialchars($images[0]['image_path']) ?>"
                            class="main-image" alt="<?= htmlspecialchars($p['name']) ?>">
                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <?php foreach ($images as $index => $img): ?>
                                <img src="uploads/<?= htmlspecialchars($img['image_path']) ?>"
                                    class="thumbnail <?= $index === 0 ? 'active' : '' ?>"
                                    data-src="uploads/<?= htmlspecialchars($img['image_path']) ?>"
                                    alt="Thumbnail <?= $index + 1 ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($p['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($p['image']) ?>" class="main-image"
                            alt="<?= htmlspecialchars($p['name']) ?>">
                    <?php else: ?>
                        <div class="main-image d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-box-open" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Info Produk -->
                <div class="col-md-6 p-4">
                    <h1 class="product-title"><?= htmlspecialchars($p['name']) ?></h1>
                    <?php
                    // gabungkan diskon bawaan produk + promosi aktif
                    $manualDiscount = !empty($p['discount']) ? (float) $p['discount'] : 0;
                    $promoDiscount = !empty($p['promo_discount']) ? (float) $p['promo_discount'] : 0;
                    $bestDiscount = max($manualDiscount, $promoDiscount);

                    $hasDiscount = $bestDiscount > 0;
                    $finalPrice = $hasDiscount
                        ? $p['price'] - ($p['price'] * $bestDiscount / 100)
                        : $p['price'];
                    ?>
                    <p class="product-price">
                        <?php if ($hasDiscount): ?>
                            <span class="text-muted text-decoration-line-through">
                                Rp <?= number_format($p['price'], 0, ',', '.') ?>
                            </span>
                            <span class="badge bg-danger ms-1">-<?= $bestDiscount ?>%</span><br>
                            <span class="fw-bold text-primary fs-6">
                                Rp <?= number_format($finalPrice, 0, ',', '.') ?>
                            </span>
                        <?php else: ?>
                            <span class="fw-bold text-primary fs-6">
                                Rp <?= number_format($p['price'], 0, ',', '.') ?>
                            </span>
                        <?php endif; ?>
                    </p>

                    <?php if ($p['stock'] > 0): ?>
                        <p class="stock-info"><i class="fas fa-check-circle"></i> Tersedia (<?= $p['stock'] ?> stok)</p>
                    <?php else: ?>
                        <p class="stock-info" style="color: #e74c3c;"><i class="fas fa-times-circle"></i> Stok habis</p>
                    <?php endif; ?>

                    <p class="description"><?= nl2br(htmlspecialchars($p['description'])) ?></p>

                    <?php if ($p['stock'] > 0): ?>
                        <form method="post" action="?page=add_to_cart">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">

                            <div class="mb-3">
                                <label for="qty" class="form-label fw-medium">Jumlah</label>
                                <input type="number" id="qty" name="qty" value="1" min="1" max="<?= $p['stock'] ?>"
                                    class="qty-input">
                            </div>

                            <button type="submit" class="btn btn-cart">
                                <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                            </button>
                        </form>

                        <a href="?page=custom_form&product_id=<?= $p['id'] ?>" class="btn btn-customize">
                            <i class="fas fa-paint-brush me-2"></i> Personalisasi Kado Ini
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="fas fa-ban me-2"></i> Tidak Tersedia
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ganti gambar utama saat thumbnail diklik
            const thumbnails = document.querySelectorAll('.thumbnail');
            const mainImage = document.getElementById('mainImage');

            if (mainImage && thumbnails.length > 0) {
                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', function () {
                        // Hapus class active dari semua
                        thumbnails.forEach(t => t.classList.remove('active'));
                        // Tambahkan ke yang diklik
                        this.classList.add('active');
                        // Ganti gambar utama
                        mainImage.src = this.getAttribute('data-src');
                    });
                });
            }

            // Validasi stok di form (opsional)
            const qtyInput = document.getElementById('qty');
            if (qtyInput) {
                const maxStock = <?= (int) $p['stock'] ?>;
                qtyInput.addEventListener('change', function () {
                    if (this.value > maxStock) {
                        this.value = maxStock;
                    }
                    if (this.value < 1) {
                        this.value = 1;
                    }
                });
            }
        });
    </script>
</body>

</html>