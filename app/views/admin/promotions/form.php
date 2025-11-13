<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $promo ? 'Edit' : 'Tambah' ?> Promosi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3><?= $promo ? 'Edit Promosi' : 'Tambah Promosi' ?></h3>
        <form method="post" action="?page=admin_promo_save">
            <input type="hidden" name="id" value="<?= $promo['id'] ?? '' ?>">

            <div class="mb-3">
                <label>Nama Promo</label>
                <input type="text" name="name" class="form-control"
                    value="<?= htmlspecialchars($promo['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label>Tipe</label>
                <select name="type" class="form-select">
                    <?php
                    $types = ['seasonal' => 'Seasonal', 'bundle' => 'Bundle', 'referral' => 'Referral', 'flash_sale' => 'Flash Sale'];
                    foreach ($types as $k => $v): ?>
                        <option value="<?= $k ?>" <?= isset($promo['type']) && $promo['type'] == $k ? 'selected' : '' ?>><?= $v ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Diskon (%)</label>
                <input type="number" name="discount" class="form-control" value="<?= $promo['discount'] ?? '' ?>"
                    required>
            </div>

            <div class="row">
                <div class="col">
                    <label>Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="<?= $promo['start_date'] ?? '' ?>"
                        required>
                </div>
                <div class="col">
                    <label>Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="<?= $promo['end_date'] ?? '' ?>"
                        required>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label>Deskripsi</label>
                <textarea name="description"
                    class="form-control"><?= htmlspecialchars($promo['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label>Pilih Produk:</label>
                <div class="border p-2" style="max-height:220px;overflow-y:auto;">
                    <?php foreach ($products as $prod): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="products[]" value="<?= $prod['id'] ?>"
                                <?= in_array($prod['id'], array_column($linked, 'product_id')) ? 'checked' : '' ?>>
                            <label class="form-check-label"><?= htmlspecialchars($prod['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-success">💾 Simpan</button>
            <a href="?page=admin_promotions" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>