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
            padding: 1.5rem 0;
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
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .color-input-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .color-input {
            width: 56px;
            height: 56px;
            padding: 0;
            border-radius: 12px;
            cursor: pointer;
            border: 1px solid #ddd;
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
            cursor: pointer;
        }

        .btn-save:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(121, 161, 191, 0.35);
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
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

        @media (max-width: 576px) {
            .personalize-card {
                padding: 1.75rem 1.25rem;
            }

            .color-input-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-save,
            .btn-cancel {
                width: 100%;
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
            <i class="fas fa-paint-brush" aria-hidden="true"></i> Personalisasi Hadiahmu
        </h1>

        <div class="personalize-card">
            <p class="text-muted mb-4">
                Tambahkan sentuhan pribadi untuk
                <strong><?= htmlspecialchars($product['name'] ?? 'produk ini', ENT_QUOTES, 'UTF-8') ?></strong> —
                buat pasanganmu tersenyum dari jarak jauh 💞
            </p>

            <form method="post" action="?page=custom_create" novalidate>
                <input type="hidden" name="cart_index" value="<?= htmlspecialchars($cartIndex, ENT_QUOTES, 'UTF-8') ?>">

                <div class="mb-4">
                    <label for="custom_text" class="form-label">Pesan Spesial untuk Pasanganmu</label>
                    <input type="text" id="custom_text" name="custom_text" class="form-control" maxlength="500"
                        placeholder="Contoh: 'Selamat ulang tahun, sayang! Aku rindu pelukanmu.'" required
                        aria-describedby="text-help">
                    <div id="text-help" class="form-text">Maks. 500 karakter</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="font_style" class="form-label">Gaya Tulisan</label>
                        <select name="font_style" id="font_style" class="form-select">
                            <option value="normal">Normal</option>
                            <option value="italic">Miring (Italic)</option>
                            <option value="bold">Tebal (Bold)</option>
                            <option value="handwritten">Tulisan Tangan</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label">Warna Teks</label>
                        <div class="color-input-group">
                            <input type="color" name="text_color" value="#000000" class="color-input"
                                aria-label="Pilih warna teks">
                            <span>Teks akan ditulis dengan warna ini</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="packaging_type" class="form-label">Kemasan Hadiah</label>
                        <select name="packaging_type" id="packaging_type" class="form-select">
                            <option value="box">Kotak Kado Elegan</option>
                            <option value="paper_wrap">Pembungkus Kertas Artistik</option>
                            <option value="bag">Tas Kado Premium</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Warna Pita</label>
                    <div class="color-input-group">
                        <input type="color" name="ribbon_color" value="#ffffff" class="color-input"
                            aria-label="Pilih warna pita">
                        <span>Pita akan diikat dengan warna ini</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="special_instructions" class="form-label">Instruksi Khusus (Opsional)</label>
                    <textarea name="special_instructions" id="special_instructions" class="form-control" rows="3"
                        placeholder="Contoh: 'Tulis di bagian dalam kartu', 'Gunakan pita emas'"
                        aria-label="Instruksi khusus untuk tim kreatif"></textarea>
                </div>

                <div class="d-flex flex-column flex-md-row gap-3">
                    <button type="submit" class="btn-save" aria-label="Simpan personalisasi">
                        <i class="fas fa-heart me-2" aria-hidden="true"></i> Simpan Personalisasi
                    </button>
                    <a href="?page=cart" class="btn-cancel" aria-label="Batalkan personalisasi">
                        <i class="fas fa-times me-2" aria-hidden="true"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>