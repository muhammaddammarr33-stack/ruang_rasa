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
            background-color: white;
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            overflow-x: hidden;
        }

        /* 🔹 Navbar */
        .navbar {
            background-color: white;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
            padding: 0.75rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .navbar-brand img {
            height: 44px;
            object-fit: contain;
        }

        .nav-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--soft-blue);
            border-radius: 8px;
            color: var(--soft-blue);
            background: transparent;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .nav-btn:hover,
        .nav-btn.active {
            background-color: var(--soft-blue);
            color: white;
        }

        .nav-logout {
            background-color: var(--soft-peach) !important;
            border-color: var(--soft-peach) !important;
            color: white !important;
        }

        .nav-logout:hover {
            background-color: #d89484 !important;
        }

        .unread-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #e74c3c;
            color: white;
            font-size: 0.65rem;
            min-width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2px;
        }

        /* 🔹 Hero Video — Full viewport height */
        .hero-video-container {
            width: 100%;
            height: 100vh;
            display: block;
            background: #000;
            overflow: hidden;
        }

        .hero-video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* 🔹 Hero Message — lega & fokus */
        .hero-message {
            background-color: var(--off-white);
            padding: 5rem 1.5rem 4rem;
            text-align: center;
        }

        .hero-message h1 {
            font-weight: 700;
            font-size: 2.2rem;
            line-height: 1.35;
            margin-bottom: 1.25rem;
            color: var(--dark-grey);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-message p {
            font-size: 1.1rem;
            color: #555;
            max-width: 700px;
            margin: 0 auto 2rem;
            line-height: 1.65;
        }

        .btn-primary-action {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 2.2rem;
            font-weight: 600;
            font-size: 1.05rem;
            transition: background-color 0.2s, transform 0.2s;
            box-shadow: 0 4px 12px rgba(121, 161, 191, 0.2);
        }

        .btn-primary-action:hover {
            background-color: #658db2;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(121, 161, 191, 0.25);
        }

        /* 🔹 Core Features — lebih lega */
        .feature-section {
            padding: 5rem 0 4rem;
            background-color: white;
        }

        .section-title {
            font-weight: 700;
            text-align: center;
            margin: 0 0 3rem;
            color: var(--dark-grey);
            position: relative;
        }

        .section-title:after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--soft-peach);
            margin: 0.75rem auto 0;
            border-radius: 2px;
        }

        .feature-card {
            text-align: center;
            padding: 2rem 1.25rem;
            border-radius: 18px;
            background: white;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
            transition: transform 0.25s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: rgba(121, 161, 191, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            color: var(--soft-blue);
            font-size: 1.5rem;
        }

        /* 🔹 Produk */
        .products-section {
            padding: 5rem 0 4rem;
            background-color: var(--off-white);
        }

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.25s;
            background: white;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-img-top {
            height: 190px;
            object-fit: cover;
        }

        .price {
            color: var(--soft-blue);
            font-weight: 700;
            font-size: 1.15rem;
            margin: 0.5rem 0;
        }

        .btn-outline-soft {
            color: var(--soft-blue);
            border: 1px solid var(--soft-blue);
            border-radius: 10px;
            padding: 0.45rem 0.8rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .btn-outline-soft:hover {
            background-color: var(--soft-blue);
            color: white;
        }

        /* 🔹 Footer CTA */
        .footer-cta {
            background-color: var(--soft-blue);
            padding: 4rem 1.5rem 3.5rem;
            color: white;
            text-align: center;
        }

        .footer-cta h3 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .footer-cta p {
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto 2rem;
            font-size: 1.05rem;
        }

        .footer-btn {
            background-color: white;
            color: var(--soft-blue);
            border: 2px solid white;
            border-radius: 12px;
            padding: 0.8rem 1.8rem;
            font-weight: 600;
            font-size: 1rem;
            margin: 0 0.5rem;
            transition: all 0.2s;
        }

        .footer-btn:hover {
            background-color: transparent;
            color: white;
            transform: translateY(-2px);
        }

        /* 🔹 Footer Lengkap */
        footer {
            background: var(--dark-grey);
            color: rgba(255, 255, 255, 0.85);
            padding: 3rem 1.5rem 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-about p {
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .footer-contact,
        .footer-links {
            margin-bottom: 1.5rem;
        }

        .footer-contact a,
        .footer-links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.2s;
        }

        .footer-contact a:hover,
        .footer-links a:hover {
            color: white;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 0.75rem;
            transition: background 0.2s;
            text-decoration: none;
        }

        .footer-social a:hover {
            background: var(--soft-blue);
        }

        .footer-bottom {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                height: 40px;
            }

            .hero-message h1 {
                font-size: 1.8rem;
            }

            .footer-grid {
                flex-direction: column;
                gap: 2rem;
            }

            .footer-btn {
                display: block;
                width: 100%;
                margin: 0.6rem 0 !important;
            }
        }
    </style>
</head>

<body>
    <!-- 🔹 Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand" href="?page=landing">
                <img src="uploads/logo.png" alt="Ruang Rasa">
            </a>

            <div class="d-flex align-items-center flex-wrap gap-1 ms-auto">
                <?php if ($user): ?>
                    <a href="?page=consultations" class="position-relative">
                        <div class="nav-btn">
                            <i class="fas fa-comments"></i>
                        </div>
                        <?php
                        $unreadCount = 0;
                        if (isset($_SESSION['user']) && $_SESSION['user']['role'] !== 'admin') {
                            $unreadCount = getUnreadConsultationCount($_SESSION['user']['id']);
                        }
                        if ($unreadCount > 0): ?>
                            <span class="unread-badge"><?= (int) $unreadCount ?></span>
                        <?php endif; ?>
                    </a>

                    <a href="?page=promotions" class="nav-btn" title="Promo">
                        <i class="fas fa-bolt"></i>
                    </a>
                    <a href="?page=profile" class="nav-btn" title="Profil">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="?page=orders" class="nav-btn" title="Pesanan">
                        <i class="fas fa-box-open"></i>
                    </a>
                    <a href="?page=cart" class="nav-btn" title="Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                    </a>

                    <?php if (($user['role'] ?? '') === 'admin'): ?>
                        <a href="?page=admin_dashboard" class="nav-btn" title="Admin">
                            <i class="fas fa-cog"></i>
                        </a>
                    <?php endif; ?>

                    <a href="?page=logout" class="nav-btn nav-logout" title="Keluar">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a href="?page=login" class="btn btn-sm"
                        style="color: var(--soft-blue); border: 1px solid var(--soft-blue); background: transparent; border-radius: 8px; padding: 0.35rem 0.75rem; font-size: 0.9rem;">
                        Masuk
                    </a>
                    <a href="?page=register" class="btn btn-sm"
                        style="background-color: var(--soft-blue); color: white; border: none; border-radius: 8px; padding: 0.35rem 0.75rem; font-size: 0.9rem;">
                        Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 🔹 Video Hero — Full viewport height -->
    <div class="hero-video-container">
        <video autoplay muted playsinline poster="videos/poster-hero.jpg" controls controlsList="nodownload">
            <source src="videos/hero-1.mp4" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>
    </div>

    <!-- 🔹 Hero Message -->
    <section class="hero-message">
        <div class="container">
            <h1>Kirim Hadiah yang Bicara dari Hati, Meski Kamu Tak Bisa Hadir</h1>
            <p>
                Di Ruang Rasa, setiap kado dirancang khusus untuk pasangan LDR — dengan pesan personal, kemasan penuh
                cinta, dan pengiriman tepat waktu.
                Karena cinta jarak jauh layak dirayakan dengan cara yang tak terlupakan.
            </p>
            <a href="?page=products" class="btn-primary-action">
                <i class="fas fa-gift me-2"></i> Jelajahi Kado Sekarang
            </a>
        </div>
    </section>

    <!-- 🔹 Fitur Utama -->
    <section class="feature-section">
        <div class="container">
            <h2 class="section-title">Mengapa Pasangan LDR Memilih Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comment-medical"></i>
                        </div>
                        <h3>Konsultasi Personal</h3>
                        <p>
                            Tim kami akan membantumu memilih hadiah yang paling menyentuh, berdasarkan kepribadian dan
                            momen spesial pasanganmu.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <h3>Personalisasi Mendalam</h3>
                        <p>
                            Tambahkan pesan tangan, pilih warna pita, desain kemasan, hingga jadwalkan pengiriman —
                            semuanya sesuai keinginanmu.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Untuk Pasangan LDR</h3>
                        <p>
                            Kami paham betapa sulitnya mengungkapkan rindu dari jarak jauh. Karena itu, setiap hadiah
                            kami adalah surat cinta dalam bentuk nyata.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 Produk Unggulan -->
    <section class="products-section">
        <div class="container">
            <h2 class="section-title">Kado Terlaris Bulan Ini</h2>
            <?php if (!empty($products)): ?>
                <div class="row g-4">
                    <?php foreach (array_slice($products, 0, 4) as $p): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100">
                                <img src="uploads/<?= htmlspecialchars($p['image'] ?? 'noimage.png', ENT_QUOTES, 'UTF-8') ?>"
                                    class="card-img-top" alt="<?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="fw-bold"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h6>
                                    <p class="text-muted small mb-1">
                                        <?= htmlspecialchars($p['category_name'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                    <p class="price">
                                        <strong>Rp <?= number_format($p['final_price'], 0, ',', '.') ?></strong>
                                    </p>
                                    <div class="mt-auto">
                                        <a href="?page=product_detail&id=<?= (int) $p['id'] ?>"
                                            class="btn-outline-soft w-100 mb-1">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="?page=products" class="btn-outline-soft">Lihat Semua Kado</a>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Belum ada produk tersedia.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- 🔹 Footer CTA -->
    <section class="footer-cta">
        <div class="container">
            <h3>Siap Bikin Pasanganmu Tersenyum Hari Ini?</h3>
            <p>
                Konsultasi gratis, tanpa komitmen. Tim kami siap membantumu merancang kejutan yang benar-benar menyentuh
                hati.
            </p>
            <a href="?page=consultation_direct" class="footer-btn">
                💬 Konsultasi Langsung via Chat
            </a>
            <a href="?page=consultation_form" class="footer-btn">
                🎁 Konsultasi Cepat
            </a>
        </div>
    </section>

    <!-- 🔹 Footer Lengkap -->
    <footer>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between footer-grid">
                <div class="footer-about">
                    <h5>Ruang Rasa</h5>
                    <p>
                        Hadiah dari hati untuk pasangan LDR.
                        Kami percaya, jarak bukan penghalang untuk mengungkapkan cinta.
                    </p>
                    <div class="footer-social">
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-contact">
                    <h5>Kontak Kami</h5>
                    <a href="mailto:halo@ruangrasa.com">halo@ruangrasa.com</a>
                    <a href="https://wa.me/6289503451582">+62 895-0345-1582</a>
                    <a href="#">Bali, Indonesia</a>
                </div>
                <div class="footer-links">
                    <h5>Link Cepat</h5>
                    <a href="?page=landing">Beranda</a>
                    <a href="?page=products">Produk</a>
                    <a href="?page=consultation_form">Konsultasi</a>
                    <a href="?page=promotions">Promo</a>

                </div>
            </div>
            <div class="footer-bottom">
                <p>© <?= date('Y') ?> Ruang Rasa — Karena Hadiah bukan cuma soal barang, Tapi soal Rasa</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.querySelector('video');
            if (video) video.addEventListener('click', () => video.muted = false);
        });
    </script>

    <!-- Crisp Chat -->
    <script>
        window.$crisp = []; window.CRISP_WEBSITE_ID = "5714b615-392f-49dc-a04b-2c4f4590d6da";
        (function () {
            d = document; s = d.createElement("script"); s.src = "https://client.crisp.chat/l.js";
            s.async = 1; d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>
</body>

</html>