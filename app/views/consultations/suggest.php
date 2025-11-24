<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Berikan Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-4">

        <h3>Berikan Rekomendasi</h3>

        <form method="post" action="?page=consultation_suggest_save&id=<?= $consultationId ?>">

            <div class="mb-3">
                <label>Pilih Produk</label>
                <select name="product_id" class="form-select" required>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['name'] ?> - Rp <?= number_format($p['price'], 0, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Alasan Rekomendasi</label>
                <textarea name="reason" class="form-control" rows="3" required></textarea>
            </div>

            <button class="btn btn-success" type="submit">Simpan Rekomendasi</button>

        </form>

    </div>

</body>

</html>