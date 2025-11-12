<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h3>Konsultasi Baru</h3>
        <form method="post" action="?page=consultation_form">
            <div class="mb-3">
                <label>Topik Konsultasi</label>
                <input type="text" name="topic" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Anggaran (Rp)</label>
                <input type="number" name="budget" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Preferensi Anda</label>
                <textarea name="preference" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Kirim Konsultasi</button>
        </form>
    </div>
</body>

</html>