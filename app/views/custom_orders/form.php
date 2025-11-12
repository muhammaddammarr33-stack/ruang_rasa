<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Personalisasi Produk: <?= htmlspecialchars($product['name']) ?></h3>

        <form method="post" action="?page=custom_form">
            <input type="hidden" name="cart_index" value="<?= $_GET['cart_index'] ?>">
            <div class="mb-3">
                <label>Teks Ucapan</label>
                <input type="text" name="custom_text" class="form-control" placeholder="Tulis pesan untuk penerima">
            </div>
            <div class="mb-3">
                <label>Gaya Font</label>
                <select name="font_style" class="form-select">
                    <option value="normal">Normal</option>
                    <option value="cursive">Cursive</option>
                    <option value="bold">Bold</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Warna Teks</label>
                <input type="color" name="text_color" value="#000000" class="form-control form-control-color">
            </div>
            <div class="mb-3">
                <label>Jenis Kemasan</label>
                <input type="text" name="packaging_type" class="form-control" placeholder="Contoh: Gift Box Premium">
            </div>
            <div class="mb-3">
                <label>Warna Pita</label>
                <input type="text" name="ribbon_color" class="form-control" placeholder="Contoh: Gold">
            </div>
            <div class="mb-3">
                <label>Instruksi Khusus</label>
                <textarea name="special_instructions" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Simpan Personalisasi</button>
        </form>
    </div>
</body>

</html>