<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <a href="?page=admin_categories" class="btn btn-link">← Kembali</a>
        <h3>Tambah Kategori</h3>
        <form method="post" action="?page=admin_category_form">
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>

</html>