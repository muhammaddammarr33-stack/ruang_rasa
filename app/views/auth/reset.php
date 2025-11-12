<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Atur Ulang Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5" style="max-width:480px;">
        <h3 class="text-center mb-4">Atur Ulang Password</h3>

        <form method="post" action="?page=reset&token=<?= htmlspecialchars($_GET['token']) ?>">
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Simpan Password Baru</button>
        </form>
    </div>
</body>

</html>