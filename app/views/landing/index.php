<?php
// app/views/landing/index.php
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Ruang Rasa - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(90deg, #ffc10720, #ff6b6b20);
            padding: 60px 0;
        }

        .product-card img {
            max-height: 160px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="?page=home">Ruang Rasa</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="?page=home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=home#produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'customer'): ?>
                        <li class="nav-item"><a class="nav-link" href="?page=user_dashboard">Dashboard Saya</a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="?page=admin_dashboard">Dashboard Saya</a></li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex me-3" method="get" action="">
                    <input type="hidden" name="page" value="home">
                    <input name="q" class="form-control me-2" placeholder="Cari produk..."
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button class="btn btn-outline-primary">Cari</button>
                </form>
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="d-flex align-items-center">
                        <span class="me-2">Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <a class="btn btn-sm btn-secondary me-2" href="?page=admin_dashboard">Admin</a>
                        <?php endif; ?>
                        <a class="btn btn-sm btn-outline-danger" href="?page=logout">Logout</a>
                    </div>
                <?php else: ?>
                    <a class="btn btn-primary me-2" href="?page=login">Login</a>
                    <a class="btn btn-outline-primary" href="?page=register">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="hero text-center">
        <div class="container">
            <h1 class="display-5">Selamat datang di Ruang Rasa</h1>
            <p class="lead">Kado, souvenir, dan custom order untuk setiap momen.</p>
            <a href="?page=home#produk" class="btn btn-lg btn-primary">Lihat Produk</a>
            <?php if (isset($_SESSION['user'])): ?>
                <?php if ($_SESSION['user']['role'] === 'customer'): ?>
                    <a href="?page=consultations" class="btn btn-lg btn-secondary">Konsultasi Sekarang</a>
                <?php else: ?>
                    <a class="btn btn-lg btn-secondary" href="?page=admin_consultations">Manage Konsultasi</a>
                <?php endif; ?>
            <?php else: ?>
                <a class="btn btn-lg btn-secondary" href="?page=login">Login to Konsultasi</a>
            <?php endif; ?>
        </div>
    </section>

    <section id="produk" class="py-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-3">
                    <h5>Filter Kategori</h5>
                    <form method="get" action="">
                        <input type="hidden" name="page" value="home">
                        <select name="category" class="form-select mb-2" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $c['id']) ? 'selected' : ''; ?>><?= htmlspecialchars($c['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <?php if (empty($products)): ?>
                            <div class="col-12">
                                <div class="alert alert-info">Produk tidak ditemukan.</div>
                            </div>
                        <?php endif; ?>
                        <?php foreach ($products as $p): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card product-card h-100">
                                    <img src="<?= $p['image_path'] ? '../public/uploads/' . htmlspecialchars($p['image_path']) : 'https://via.placeholder.com/400x250?text=No+Image' ?>"
                                        class="card-img-top" alt="">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                                        <p class="card-text small text-muted mb-2">
                                            <?= htmlspecialchars(substr($p['description'], 0, 120)) ?>
                                        </p>
                                        <div class="mt-auto">
                                            <strong><?php
                                            $finalPrice = $p['price'] * (1 - $p['discount'] / 100);
                                            ?>
                                                <h4 class="text-danger">Rp <?= number_format($finalPrice, 0, ',', '.') ?>
                                                </h4>
                                                <?php if ($p['discount'] > 0): ?>
                                                    <small class="text-muted"><del>Rp
                                                            <?= number_format($p['price'], 0, ',', '.') ?></del> (Diskon
                                                        <?= $p['discount'] ?>%)</small>
                                                <?php endif; ?>
                                            </strong>
                                            <div class="d-flex justify-content-between mt-2">
                                                <?php if (isset($_SESSION['user'])): ?>
                                                    <?php if ($_SESSION['user']['role'] === 'customer'): ?>
                                                        <a href="?page=add_to_cart&id=<?= $p['id'] ?>"
                                                            class="btn btn-sm btn-primary">Tambah ke Keranjang</a>
                                                    <?php else: ?>
                                                        <a class="btn btn-sm btn-outline-secondary"
                                                            href="?page=admin_products">Manage</a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <a class="btn btn-sm btn-primary" href="?page=login">Login to Buy</a>
                                                <?php endif; ?>
                                                <a class="btn btn-sm btn-outline-secondary"
                                                    href="?page=product_detail&id=<?= $p['id'] ?>">Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h3>Tentang Ruang Rasa</h3>
            <p>Ruang Rasa menyediakan solusi kado custom untuk moment spesial. (Isi sesuai kebutuhan)</p>
        </div>
    </section>

    <footer class="py-3 text-center">
        <div class="container">
            <small>&copy; <?= date('Y') ?> Ruang Rasa</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>