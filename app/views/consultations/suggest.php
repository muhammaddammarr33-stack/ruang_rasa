<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berikan Rekomendasi | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .recommend-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            max-width: 650px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark-grey);
        }

        .form-select,
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .btn-submit {
            background-color: var(--soft-peach);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            font-size: 1.05rem;
            transition: background-color 0.2s, transform 0.2s;
            cursor: pointer;
        }

        .btn-submit:hover:not(:disabled) {
            background-color: #d89484;
            transform: translateY(-2px);
        }

        .product-option {
            font-family: 'Poppins', sans-serif;
        }

        @media (max-width: 576px) {
            .recommend-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="recommend-card">
            <h3 class="mb-4">Berikan Rekomendasi</h3>

            <form method="post" action="?page=consultation_suggest_save&id=<?= (int) $consultationId ?>" novalidate>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Pilih Produk</label>
                    <select name="product_id" id="product_id" class="form-select product-option" required
                        aria-describedby="product-help">
                        <option value="">Pilih produk dari daftar</option>
                        <?php foreach ($products as $p): ?>
                            <option value="<?= (int) $p['id'] ?>">
                                <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?> — Rp
                                <?= number_format($p['price'], 0, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="product-help" class="form-text">Pilih kado yang paling sesuai dengan kebutuhan klien</div>
                </div>

                <div class="mb-4">
                    <label for="reason" class="form-label">Alasan Rekomendasi</label>
                    <textarea name="reason" id="reason" class="form-control" rows="4"
                        placeholder="Jelaskan mengapa produk ini cocok, misalnya: 'Karena penerima suka hal minimalis dan produk ini elegan namun fungsional.'"
                        required aria-label="Alasan rekomendasi produk"></textarea>
                </div>

                <button type="submit" class="btn-submit" aria-label="Simpan rekomendasi untuk konsultasi ini">
                    Simpan Rekomendasi
                </button>
            </form>
        </div>
    </div>
</body>

</html>