<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $promo ? 'Edit' : 'Tambah' ?> Promosi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #7093B3;
            --accent-hover: #5d7da0;
            --dark: #343D46;
            --muted: #6c757d;
            --border: #e9ecef;
        }

        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', system-ui, sans-serif;
            color: var(--dark);
            font-size: 0.875rem;
            padding-top: 1rem;
            padding-bottom: 1.5rem;
        }

        .container {
            max-width: 720px;
        }

        h3 {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
            color: var(--dark);
        }

        .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.375rem;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            font-size: 0.875rem;
            padding: 0.625rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(112, 147, 179, 0.15);
            outline: none;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check-label {
            font-size: 0.875rem;
            padding-top: 0.125rem;
        }

        .btn {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-success {
            background-color: var(--accent);
            border: 1px solid var(--accent);
            color: white;
        }

        .btn-success:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        .product-list {
            border: 1px solid var(--border);
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
            padding: 0.5rem;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3><?= $promo ? 'Edit Promosi' : 'Tambah Promosi' ?></h3>

        <form method="post" action="?page=admin_promo_save">
            <input type="hidden" name="id" value="<?= $promo['id'] ?? '' ?>">

            <div class="mb-3">
                <label class="form-label">Nama Promo</label>
                <input type="text" name="name" class="form-control"
                    value="<?= htmlspecialchars($promo['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-select">
                    <?php
                    $types = ['seasonal' => 'Seasonal', 'bundle' => 'Bundle', 'referral' => 'Referral', 'flash_sale' => 'Flash Sale'];
                    foreach ($types as $k => $v): ?>
                        <option value="<?= $k ?>" <?= isset($promo['type']) && $promo['type'] == $k ? 'selected' : '' ?>>
                            <?= $v ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Diskon (%)</label>
                <input type="number" name="discount" class="form-control" value="<?= $promo['discount'] ?? '' ?>"
                    required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="<?= $promo['start_date'] ?? '' ?>"
                        required>
                </div>
                <div class="col">
                    <label class="form-label">Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="<?= $promo['end_date'] ?? '' ?>"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control"
                    rows="3"><?= htmlspecialchars($promo['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Produk:</label>
                <div class="product-list">
                    <?php foreach ($products as $prod): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="products[]" value="<?= $prod['id'] ?>"
                                <?= in_array($prod['id'], array_column($linked ?? [], 'product_id')) ? 'checked' : '' ?>>
                            <label class="form-check-label"><?= htmlspecialchars($prod['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">💾 Simpan</button>
                <a href="?page=admin_promotions" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>