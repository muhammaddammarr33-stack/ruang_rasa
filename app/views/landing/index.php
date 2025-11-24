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
            margin-bottom: 3rem;
        }

        .hero-thumbnails button {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hero-thumbnails button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-special {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(121, 161, 191, 0.4);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-special:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(121, 161, 191, 0.5);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem !important;
            }

            .lead {
                font-size: 1rem !important;
            }
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
    <!-- 🔹 Navbar — Logo diperbesar & tampilan profesional -->
    <nav class="navbar navbar-expand-lg"
        style="padding: 0.5rem 0; background-color: #F5F5EC; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
        <div class="container d-flex align-items-center">
            <!-- Logo: lebih kecil, tanpa background, tanpa padding berlebih -->
            <a class="navbar-brand d-flex align-items-center" href="?page=landing">
                <img src="uploads/bhot1.png" alt="Ruang Rasa" style="
                height: 36px;
                width: auto;
                object-fit: contain;
                /* Tidak ada background, tidak ada padding internal */
                " class="me-3">
            </a>

            <!-- Menu & Tombol -->
            <div class="d-flex align-items-center flex-wrap gap-2 ms-auto">
                <?php if ($user): ?>
                    <span class="d-none d-md-inline" style="color: #343D46; font-size: 0.9rem;">
                        Halo, <b><?= htmlspecialchars($user['name'] ?? 'Teman') ?></b>
                    </span>
                    <!-- Di navbar landing -->
                    <a href="?page=consultations" class="position-relative">
                        💬 Konsultasi
                        <?php if (!empty($unreadConsultations) && $unreadConsultations > 0): ?>
                            <span class="badge bg-danger rounded-pill"
                                style="position: absolute; top: -5px; right: -10px; font-size: 0.7em;">
                                <?= $unreadConsultations ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <a href="?page=promotions" class="btn btn-sm"
                        style="color: #79A1BF; border: 1px solid #79A1BF; background: transparent;" title="Promo">
                        <i class="fas fa-bolt"></i>
                    </a>
                    <a href="?page=profile" class="btn btn-sm"
                        style="color: #79A1BF; border: 1px solid #79A1BF; background: transparent;" title="Profil">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="?page=orders" class="btn btn-sm"
                        style="color: #79A1BF; border: 1px solid #79A1BF; background: transparent;" title="Riwayat Pesanan">
                        <i class="fas fa-box-open"></i>
                    </a>
                    <a href="?page=cart" class="btn btn-sm"
                        style="color: #79A1BF; border: 1px solid #79A1BF; background: transparent;" title="Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <?php if (($user['role'] ?? '') === 'admin'): ?>
                        <a href="?page=admin_dashboard" class="btn btn-sm"
                            style="color: #343D46; border: 1px solid #343D46; background: transparent;" title="Dashboard Admin">
                            <i class="fas fa-cog"></i>
                        </a>
                    <?php endif; ?>
                    <a href="?page=logout" class="btn btn-sm" style="background-color: #E7A494; color: white; border: none;"
                        title="Keluar">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a href="?page=login" class="btn btn-sm"
                        style="color: #79A1BF; border: 1px solid #79A1BF; background: transparent;">
                        Masuk
                    </a>
                    <a href="?page=register" class="btn btn-sm"
                        style="background-color: #79A1BF; color: white; border: none;">
                        Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 🔹 Hero Section — Auto-play dengan Suara, Warna Harmonis -->
    <section class="hero position-relative overflow-hidden" style="background-color: var(--off-white);">
        <div class="position-relative mx-auto" style="height: 80vh; max-height: 700px; width: 95%; max-width: 1400px;">
            <!-- Background brand di luar area video -->
            <div class="w-100 h-100 d-flex justify-content-center align-items-center"
                style="background-color: var(--off-white);">
                <video id="mainVideo" class="w-100 h-100" autoplay muted playsinline poster="videos/poster-hero.jpg"
                    style="object-fit: contain; background: #000;" controls controlsList="nodownload">
                    <source src="videos/hero-1.mp4" type="video/mp4">
                    Browser Anda tidak mendukung video.
                </video>
            </div>

            <!-- Overlay teks dengan warna disesuaikan -->
            <div
                class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
                <div class="max-w-lg">
                    <h1 class="fw-bold mb-3 text-white"
                        style="font-size: 2.4rem; line-height: 1.2; text-shadow: 0 2px 8px rgba(0,0,0,0.7);">
                        Kirim Cinta yang Bisa Dirasakan, Meski Jarak Memisahkan 💞
                    </h1>
                    <p class="lead opacity-90 mb-4 text-white"
                        style="font-size: 1.2rem; text-shadow: 0 1px 4px rgba(0,0,0,0.6);">
                        Hadiah personal, surat digital, dan kejutan spesial — semua dirancang untuk menyampaikan rasa
                        dari jarak jauh.
                    </p>
                    <a href="?page=products" class="btn btn-special px-4 py-2" style="font-size: 1.1rem;">
                        <i class="fas fa-gift me-2"></i> Jelajahi Kado Spesial
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        :root {
            --off-white: #F5F5EC;
            --soft-blue: #79A1BF;
            --soft-peach: #E7A494;
            --dark-grey: #343D46;
        }

        .hero {
            margin-bottom: 3rem;
        }

        /* Kontrol native: pastikan muncul di bawah */
        .hero video {
            border-radius: 8px;
        }

        .btn-special {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(121, 161, 191, 0.4);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-special:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(121, 161, 191, 0.5);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem !important;
            }

            .lead {
                font-size: 1rem !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('mainVideo');
            if (!video) return;

            // Aktifkan suara saat pengguna klik video
            let soundEnabled = false;
            video.addEventListener('click', () => {
                if (!soundEnabled) {
                    video.muted = false;
                    soundEnabled = true;
                    // Opsional: tampilkan notifikasi "Suara aktif"
                }
            });

            // Auto-pause saat scroll keluar
            const videoContainer = video.closest('.position-relative');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting && !video.paused) {
                        video.pause();
                    }
                });
            }, { threshold: 0.1 });
            observer.observe(videoContainer);
        });
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
            <!-- Konsultasi Cepat -->
            <a href="?page=consultation_form" class="btn"
                style="background-color: #79A1BF; color: white; border-radius: 12px; padding: 12px 24px; margin-right: 16px;">
                🎁 Konsultasi Cepat
            </a>

            <!-- Konsultasi Langsung -->
            <a href="?page=consultation_direct" class="btn"
                style="background-color: #E7A494; color: white; border-radius: 12px; padding: 12px 24px;">
                💬 Konsultasi Langsung
            </a>
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
    <script
        type="text/javascript">window.$crisp = []; window.CRISP_WEBSITE_ID = "5714b615-392f-49dc-a04b-2c4f4590d6da"; (function () { d = document; s = d.createElement("script"); s.src = "https://client.crisp.chat/l.js"; s.async = 1; d.getElementsByTagName("head")[0].appendChild(s); })();</script>

</body>

</html>