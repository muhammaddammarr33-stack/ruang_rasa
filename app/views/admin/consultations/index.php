<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Konsultasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #7093B3;
            --accent-hover: #5d7da0;
            --dark: #343D46;
            --muted: #6c757d;
            --border: #e9ecef;
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
            max-width: 1000px;
        }

        h3 {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert {
            font-size: 0.875rem;
            padding: 0.625rem 1rem;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        table {
            font-size: 0.875rem;
            margin-top: 0.75rem;
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

        .status-badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 0.8125rem;
            font-weight: 500;
            border-radius: 4px;
            background-color: #e9ecef;
            color: var(--dark);
        }

        .status-badge.waiting {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.ready {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-badge.progress {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-badge.completed {
            background-color: #d4edda;
            color: #155724;
        }

        .btn {
            font-size: 0.8125rem;
            padding: 0.375rem 0.625rem;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-success {
            background-color: var(--accent);
            border: 1px solid var(--accent);
            color: white;
        }

        .btn-success:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .btn-outline-primary {
            color: var(--accent);
            border-color: var(--accent);
        }

        .btn-outline-primary:hover {
            background-color: rgba(112, 147, 179, 0.08);
            border-color: var(--accent-hover);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--dark);
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
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
        <h3>📋 Daftar Konsultasi</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Untuk</th>
                    <th>Anggaran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['user_name']) ?></td>
                        <td><?= htmlspecialchars($c['recipient'] ?? '–') ?></td>
                        <td><?= htmlspecialchars($c['budget_range'] ?? '–') ?></td>
                        <td>
                            <?php
                            $statusMap = [
                                'submitted' => ['label' => 'Menunggu', 'class' => 'waiting'],
                                'suggested' => ['label' => 'Rekomendasi Siap', 'class' => 'ready'],
                                'in_progress' => ['label' => 'Sedang Berlangsung', 'class' => 'progress'],
                                'completed' => ['label' => 'Selesai', 'class' => 'completed']
                            ];
                            $status = $statusMap[$c['status']] ?? ['label' => ucfirst($c['status']), 'class' => ''];
                            echo '<span class="status-badge ' . $status['class'] . '">' . htmlspecialchars($status['label']) . '</span>';
                            ?>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($c['created_at'])) ?></td>
                        <td>
                            <?php if ($c['status'] === 'submitted'): ?>
                                <a href="?page=consultation_suggest&id=<?= $c['id'] ?>" class="btn btn-success">
                                    ➕ Rekomendasi
                                </a>
                            <?php else: ?>
                                <a href="?page=admin_consultation_detail&id=<?= $c['id'] ?>" class="btn btn-outline-primary">
                                    👁️ Detail
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="?page=admin_dashboard" class="btn btn-secondary mt-3">
            ⬅ Kembali
        </a>
    </div>
</body>

</html>