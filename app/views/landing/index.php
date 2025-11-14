<?php
if (!isset($_SESSION))
    session_start();
$user = $_SESSION['user'] ?? null;
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruang Rasa | Hadiah Penuh Makna untuk Pasangan LDR</title>

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
            overflow-x: hidden;
        }

        /* 🔹 Navbar */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--soft-blue) !important;
        }

        .navbar-brand i {
            color: var(--soft-peach);
        }

        .btn-outline-primary {
            color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-outline-primary:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        .btn-primary {
            background-color: var(--soft-blue);
            border: none;
        }

        .btn-primary:hover {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        /* 🔹 Hero */
        .hero {
            background: var(--off-white);
            padding: 4rem 0 3rem;
            text-align: center;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 2.2rem;
            color: var(--dark-grey);
            max-width: 700px;
            margin: 0 auto 1.2rem;
            line-height: 1.3;
        }

        .hero p.lead {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .btn-special {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            font-weight: 600;
            border: none;
            padding: 0.85rem 2.2rem;
            border-radius: 14px;
            font-size: 1.05rem;
            box-shadow: 0 4px 12px rgba(121, 161, 191, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-special:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(121, 161, 191, 0.4);
        }

        /* 🔹 Section Umum */
        .section-title {
            font-weight: 700;
            text-align: center;
            margin-bottom: 2.5rem;
            color: var(--dark-grey);
            position: relative;
        }

        .section-title:after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--soft-peach);
            margin: 0.5rem auto;
            border-radius: 2px;
        }

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s;
            background: white;
        }

        .card:hover {
            transform: translateY(-6px);
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

        /* 🔹 Fitur LDR */
        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(121, 161, 191, 0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--soft-blue);
            font-size: 1.4rem;
        }

        /* 🔹 Testimoni */
        .testimonial {
            background: white;
            padding: 1.8rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 1.5rem;
        }

        .quote {
            font-style: italic;
            line-height: 1.6;
            color: var(--dark-grey);
        }

        .author {
            font-weight: 600;
            color: var(--soft-blue);
            margin-top: 0.75rem;
        }

        /* 🔹 Footer */
        footer {
            background: var(--dark-grey);
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 4rem;
        }

        /* 🔹 Hero Video */
        .hero-video-container {
            max-width: 640px;
            width: 100%;
            margin: 0 auto 1.5rem;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .hero-video-container video {
            width: 100%;
            display: block;
            aspect-ratio: 16 / 9;
        }

        .hero-thumbnails {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 1.25rem;
        }

        .hero-thumbnails button {
            width: 90px;
            height: 60px;
            padding: 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            overflow: hidden;
        }

        .hero-thumbnails video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Responsif */
        @media (max-width: 576px) {
            .hero h1 {
                font-size: 1.8rem;
            }

            .btn-special {
                padding: 0.75rem 1.8rem;
                font-size: 1rem;
            }

            .navbar .btn {
                padding: 0.35rem 0.6rem !important;
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>
    <!-- 🔹 Navbar — dirapikan dengan ikon & teks lebih profesional -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="?page=landing">
                <i class="fas fa-gift"></i> Ruang Rasa
            </a>
            <div class="d-flex align-items-center flex-wrap gap-1">
                <?php if ($user): ?>
                    <span class="me-2 d-none d-md-inline text-muted">Halo,
                        <b><?= htmlspecialchars($user['name'] ?? 'Teman') ?></b></span>
                    <a href="?page=promotions" class="btn btn-outline-secondary btn-sm" title="Promo">
                        <i class="fas fa-bolt"></i>
                    </a>
                    <a href="?page=profile" class="btn btn-outline-secondary btn-sm" title="Profil">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="?page=orders" class="btn btn-outline-secondary btn-sm" title="Riwayat Pesanan">
                        <i class="fas fa-box-open"></i>
                    </a>
                    <a href="?page=cart" class="btn btn-outline-secondary btn-sm" title="Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <?php if (($user['role'] ?? '') === 'admin'): ?>
                        <a href="?page=admin_dashboard" class="btn btn-outline-dark btn-sm" title="Dashboard Admin">
                            <i class="fas fa-cog"></i>
                        </a>
                    <?php endif; ?>
                    <a href="?page=logout" class="btn btn-sm"
                        style="background-color: var(--soft-peach); color: white; border: none;" title="Keluar">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a href="?page=login" class="btn btn-outline-primary btn-sm">Masuk</a>
                    <a href="?page=register" class="btn btn-primary btn-sm">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 🔹 Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="text-center mb-5">
                <h1>Kirim Hadiah Penuh Makna untuk Pasangan LDR-mu 💞</h1>
                <p class="lead text-muted">
                    Personalisasi kado, kirim surat digital, atau atur kejutan di hari spesial — semua bisa dari jarak
                    jauh.
                </p>
            </div>

            <div class="hero-video-container">
                <video id="mainVideo" controls playsinline poster="public/videos/poster-hero.jpg">
                    <source src="videos/hero-5.mp4" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video.
                </video>
            </div>

            <div class="hero-thumbnails">
                <?php
                $videos = [
                    ['src' => 'videos/hero-5.mp4', 'title' => 'Cerita dari Hati'],
                    ['src' => 'videos/hero-6.mp4', 'title' => 'Surat Digital'],
                    ['src' => 'videos/hero-7.mp4', 'title' => 'Unboxing Anniversary'],
                    ['src' => 'videos/hero-8.mp4', 'title' => 'Personalisasi Kado']
                ];
                foreach ($videos as $vid): ?>
                    <button type="button" title="<?= htmlspecialchars($vid['title']) ?>"
                        onclick="changeVideo('<?= htmlspecialchars($vid['src']) ?>')">
                        <video muted preload="none">
                            <source src="<?= htmlspecialchars($vid['src']) ?>" type="video/mp4">
                        </video>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="?page=products" class="btn btn-special">Jelajahi Koleksi Hadiah</a>
            </div>
        </div>
    </section>

    <script>
        function changeVideo(src) {
            const mainVideo = document.getElementById('mainVideo');
            mainVideo.src = src;
            mainVideo.load();
            mainVideo.play();
        }
    </script>

    <!-- 🔹 Fitur LDR (Value Proposition) -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Dirancang Khusus untuk Pasangan LDR</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5>Surat Digital Personal</h5>
                    <p class="text-muted">Tulis pesan haru yang dikirim langsung ke email pasanganmu.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h5>Kado yang Bisa Dipersonalisasi</h5>
                    <p class="text-muted">Tambahkan foto, pesan, atau pilih kemasan eksklusif.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5>Jadwalkan Kejutan Spesial</h5>
                    <p class="text-muted">Kirim hadiah tepat di hari ulang tahun atau anniversary.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 Produk Unggulan -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title">Kado Terlaris</h2>

            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach (array_slice($products, 0, 4) as $p): ?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100">
                                <img src="uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png') ?>" class="card-img-top"
                                    alt="<?= htmlspecialchars($p['name']) ?>">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title"><?= htmlspecialchars($p['name']) ?></h6>
                                    <p class="text-muted small mb-1"><?= htmlspecialchars($p['category_name'] ?? '') ?></p>
                                    <p class="price mb-2">
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
                                            class="btn btn-outline-primary btn-sm w-100 mb-1">Detail</a>
                                        <form method="post" action="?page=add_to_cart" class="mt-1">
                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Tambah ke
                                                Keranjang</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="?page=products" class="btn btn-outline-primary">Lihat Semua Produk</a>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Belum ada produk tersedia.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- 🔹 Testimoni -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Mereka Sudah Mengirim Cinta dari Jarak Jauh</h2>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="testimonial">
                        <p class="quote">
                            “Pacarku menangis haru saat menerima kado dari Ruang Rasa. Aku di Jerman, dia di Jogja —
                            tapi rasanya kami dekat sekali.”
                        </p>
                        <p class="author">— Dinda & Raka, LDR selama 2 tahun</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 CTA Akhir -->
    <section class="py-5 text-center" style="background: rgba(121, 161, 191, 0.06);">
        <div class="container">
            <h3>Siap Kirim Kejutan yang Tak Terlupakan?</h3>
            <p class="text-muted mt-2">Buat akun gratis dan wujudkan hadiah pertamamu hari ini.</p>
            <a href="?page=register" class="btn btn-special mt-3">Mulai Sekarang</a>
        </div>
    </section>

    <!-- 🔹 Footer -->
    <footer>
        <p>© <?= date('Y') ?> Ruang Rasa — Hadiah dari Hati untuk Pasangan LDR</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-6px)');
                card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0)');
            });
        });
    </script>

</body>

</html>