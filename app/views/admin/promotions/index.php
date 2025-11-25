<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Promosi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #7093B3;
            --accent-hover: #5d7da0;
            --dark: #343D46;
            --muted: #6c757d;
            --border: #e9ecef;
            --warning-bg: #fff3cd;
            --warning-border: #ffeaa7;
            --warning-text: #856404;
            --danger-bg: #f8d7da;
            --danger-border: #f5c6cb;
            --danger-text: #721c24;
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
            max-width: 960px;
        }

        h3 {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            font-size: 0.8125rem;
            padding: 0.375rem 0.625rem;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--accent);
            border: 1px solid var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .alert {
            font-size: 0.875rem;
            padding: 0.625rem 1rem;
            border-radius: 6px;
            border: 1px solid #d1e7dd;
            background-color: #f8f9fa;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        table {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        table thead th {
            background-color: #fafafa;
            font-weight: 600;
            font-size: 0.8125rem;
            padding: 0.625rem 0.75rem;
            color: var(--dark);
            border: 1px solid var(--border);
        }

        table tbody td {
            padding: 0.625rem 0.75rem;
            vertical-align: middle;
            border: 1px solid var(--border);
        }

        table tbody tr:hover {
            background-color: rgba(112, 147, 179, 0.04);
        }

        .btn-warning {
            background-color: var(--warning-bg);
            border: 1px solid var(--warning-border);
            color: var(--warning-text);
        }

        .btn-warning:hover {
            background-color: #ffecb5;
        }

        .btn-danger {
            background-color: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
        }

        .btn-danger:hover {
            background-color: #f1b0b7;
        }

        .empty-cell {
            color: var(--muted);
            font-style: italic;
            font-size: 0.875rem;
            padding: 1rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="?page=admin_dashboard">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
        <h3>🎯 Daftar Promosi</h3>

        <a href="?page=admin_promo_form" class="btn btn-primary mb-2">+ Tambah Promosi</a>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Diskon</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($promos)): ?>
                    <tr>
                        <td colspan="5" class="empty-cell">Belum ada promosi.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($promos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['type']) ?></td>
                            <td><?= (int) ($p['discount']) ?>%</td>
                            <td><?= $p['start_date'] ?> → <?= $p['end_date'] ?></td>
                            <td>
                                <a href="?page=admin_promo_form&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">
                                    ✏️ Edit
                                </a>
                                <a href="?page=admin_promo_delete&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus promosi ini?')">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>