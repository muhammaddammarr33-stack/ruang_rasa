<?php // app/views/custom_orders/form.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$cartIndex = $_GET['cart_index'] ?? null;
$product = $product ?? null; // from controller
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personalisasi Produk | Ruang Rasa</title>

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

        .personalize-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .personalize-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2.25rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-select,
        .form-control-color {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .btn-save {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 600;
            font-size: 1.05rem;
            box-shadow: 0 4px 10px rgba(121, 161, 191, 0.25);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(121, 161, 191, 0.35);
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
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

        .color-preview {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-left: 0.5rem;
            vertical-align: middle;
            border: 1px solid #ccc;
        }

        @media (max-width: 576px) {
            .personalize-card {
                padding: 1.75rem 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=landing">Beranda</a></li>
                <li class="breadcrumb-item"><a href="?page=cart">Keranjang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Personalisasi</li>
            </ol>
        </nav>

        <h1 class="personalize-header">
            <i class="fas fa-paint-brush"></i> Personalisasi Hadiahmu
        </h1>

        <div class="personalize-card">
            <p class="text-muted mb-4">
                Tambahkan sentuhan pribadi untuk <?= htmlspecialchars($product['name'] ?? 'produk ini') ?> —
                buat pasanganmu tersenyum dari jarak jauh 💞
            </p>

            <form method="post" action="?page=custom_create">
                <input type="hidden" name="cart_index" value="<?= htmlspecialchars($cartIndex) ?>">

                <div class="mb-4">
                    <label class="form-label">Pesan Spesial untuk Pasanganmu</label>
                    <input type="text" name="custom_text" class="form-control" maxlength="500"
                        placeholder="Contoh: 'Selamat ulang tahun, sayang! Aku rindu pelukanmu.'" required>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Gaya Tulisan</label>
                        <select name="font_style" class="form-select">
                            <option value="normal">Normal</option>
                            <option value="italic">Miring (Italic)</option>
                            <option value="bold">Tebal (Bold)</option>
                            <option value="handwritten">Tulisan Tangan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warna Teks</label>
                        <div class="d-flex align-items-center">
                            <input type="color" name="text_color" value="#000000"
                                class="form-control form-control-color" style="height: 46px; width: 60px; padding: 0;">
                            <span class="ms-2">Pilih warna teks</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kemasan Hadiah</label>
                        <select name="packaging_type" class="form-select">
                            <option value="box">Kotak Kado Elegan</option>
                            <option value="paper_wrap">Pembungkus Kertas Artistik</option>
                            <option value="bag">Tas Kado Premium</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Warna Pita</label>
                    <div class="d-flex align-items-center">
                        <input type="color" name="ribbon_color" value="#ffffff" class="form-control form-control-color"
                            style="height: 46px; width: 60px; padding: 0;">
                        <span class="ms-2">Pilih warna pita</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Instruksi Khusus (Opsional)</label>
                    <textarea name="special_instructions" class="form-control" rows="3"
                        placeholder="Contoh: 'Tulis di bagian dalam kartu', 'Gunakan pita emas'"></textarea>
                </div>

                <div class="d-flex gap-3 flex-column flex-md-row">
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-heart me-2"></i> Simpan Personalisasi
                    </button>
                    <a href="?page=cart" class="btn btn-secondary text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>