<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <h2 class="mb-4 text-center fw-bold">📊 Dashboard Admin</h2>

        <div class="row g-3">
            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalProducts ?></h5>
                        <p class="text-muted small">Kategori</p>
                        <a href="?page=admin_categories" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalProducts ?></h5>
                        <p class="text-muted small">Produk</p>
                        <a href="?page=admin_products" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalOrders ?></h5>
                        <p class="text-muted small">Pesanan</p>
                        <a href="?page=admin_orders" class="btn btn-sm btn-outline-primary">Lihat</a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalPromos ?></h5>
                        <p class="text-muted small">Promo Aktif</p>
                        <a href="?page=admin_promotions" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalConsult ?></h5>
                        <p class="text-muted small">Konsultasi</p>
                        <a href="?page=admin_consultations" class="btn btn-sm btn-outline-primary">Cek</a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalCustom ?></h5>
                        <p class="text-muted small">Personalisasi</p>
                        <a href="?page=admin_custom_orders" class="btn btn-sm btn-outline-primary">Lihat</a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold"><?= $totalMembers ?></h5>
                        <p class="text-muted small">Membership</p>
                        <a href="?page=admin_memberships" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <a href="?page=landing" class="btn btn-secondary">🏠 Kembali ke Halaman Utama</a>
            <a href="?page=logout" class="btn btn-danger">🚪 Logout</a>
        </div>
    </div>
</body>

</html>