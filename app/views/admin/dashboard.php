<?php
require_once __DIR__ . '/../../models/DB.php';
$db = DB::getInstance();

$stats = [
    'products' => $db->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'categories' => $db->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    'orders' => $db->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'consultations' => $db->query("SELECT COUNT(*) FROM consultations")->fetchColumn(),
];
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h2>Dashboard Admin</h2>
        <p>Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</p>
        <a href="?page=landing" class="btn btn-primary">Tampilan Landing</a>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Produk</h5>
                    <p class="fs-4"><?= $stats['products'] ?></p>
                    <a href="?page=admin_products" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Kategori</h5>
                    <p class="fs-4"><?= $stats['categories'] ?></p>
                    <a href="?page=admin_categories" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Pesanan</h5>
                    <p class="fs-4"><?= $stats['orders'] ?></p>
                    <a href="?page=admin_orders" class="btn btn-warning btn-sm">Lihat</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Konsultasi</h5>
                    <p class="fs-4"><?= $stats['consultations'] ?></p>
                    <a href="?page=admin_consultations" class="btn btn-success btn-sm">Pantau</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>