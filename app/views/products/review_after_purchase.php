<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Beri Ulasan Setelah Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="?page=user_orders" class="btn btn-secondary mb-3">← Kembali</a>

        <div class="card p-4 shadow-sm">
            <h4 class="mb-3">Ulasan Produk</h4>
            <div class="d-flex align-items-center mb-3">
                <img src="public/uploads/<?= $product['image'] ?? 'default.jpg' ?>" width="80" height="80"
                    class="rounded me-3" style="object-fit:cover;">
                <div>
                    <h5><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="text-muted mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                </div>
            </div>

            <form method="post" action="?page=add_review_after_purchase">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select" required>
                        <option value="">Pilih Rating</option>
                        <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                        <option value="4">⭐⭐⭐⭐ Puas</option>
                        <option value="3">⭐⭐⭐ Cukup</option>
                        <option value="2">⭐⭐ Kurang</option>
                        <option value="1">⭐ Buruk</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tulis Ulasan</label>
                    <textarea name="review" class="form-control" rows="3" placeholder="Ceritakan pengalaman Anda..."
                        required></textarea>
                </div>

                <button type="submit" class="btn btn-success">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</body>

</html>