<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Konsultasi | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --off-white: #F5F5EC;
            --soft-blue: #79A1BF;
            --soft-peach: #E7A494;
            --dark-grey: #343D46;
            --status-waiting: #e9ecef;
            --status-progress: #d1e7ff;
            --status-ready: #d1f0d8;
            --status-completed: #c8e6c9;
        }

        body {
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            padding: 1rem 0;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .consult-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: rgba(231, 164, 148, 0.2);
            border: none;
            color: var(--dark-grey);
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-submitted {
            background-color: var(--status-waiting);
            color: #6c757d;
        }

        .status-suggested {
            background-color: var(--status-ready);
            color: #28a745;
        }

        .status-in_progress {
            background-color: var(--status-progress);
            color: #0d6efd;
        }

        .status-completed {
            background-color: var(--status-completed);
            color: #198754;
        }

        /* Custom buttons */
        .btn-chat {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-chat:hover {
            background-color: #658db2;
        }

        .btn-feedback {
            background-color: var(--soft-peach);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-feedback:hover {
            background-color: #d89484;
        }

        .btn-secondary-custom,
        .btn-success-custom {
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 0.5rem;
        }

        .btn-secondary-custom {
            background-color: #f0f0f0;
            color: var(--dark-grey);
        }

        .btn-secondary-custom:hover {
            background-color: #e0e0e0;
        }

        .btn-success-custom {
            background-color: var(--soft-peach);
            color: white;
        }

        .btn-success-custom:hover {
            background-color: #d89484;
        }

        /* Mobile: tampilan card */
        @media (max-width: 768px) {
            .consult-table thead {
                display: none;
            }

            .consult-table tbody,
            .consult-table tr {
                display: block;
            }

            .consult-table tr {
                background: white;
                border-radius: 14px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .consult-table td {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0 !important;
                border: none;
                flex-wrap: wrap;
            }

            .consult-table td:before {
                content: attr(data-label) ": ";
                font-weight: 600;
                color: var(--dark-grey);
                flex: 0 0 100px;
            }

            .consult-table td:last-child {
                flex-direction: column;
                gap: 0.4rem;
                align-items: flex-start;
            }

            .consult-table td:last-child:before {
                content: "Aksi:";
                margin-bottom: 0.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=landing">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
            </ol>
        </nav>
        <h3 class="page-header">Daftar Konsultasi Anda</h3>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert" aria-live="polite">
                <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($consultations)): ?>
            <div class="text-center py-4 consult-card">
                <p class="text-muted">Belum ada konsultasi.</p>
                <a href="?page=consultation_form" class="btn-success-custom">+ Mulai Konsultasi Baru</a>
            </div>
        <?php else: ?>
            <div class="consult-card">
                <table class="table consult-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Untuk</th>
                            <th scope="col">Acara</th>
                            <th scope="col">Anggaran</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultations as $c): ?>
                            <tr>
                                <td data-label="ID"><?= (int) $c['id'] ?></td>
                                <td data-label="Untuk"><?= htmlspecialchars($c['recipient'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                <td data-label="Acara"><?= htmlspecialchars($c['occasion'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                <td data-label="Anggaran">
                                    <?= htmlspecialchars($c['budget_range'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td data-label="Status">
                                    <?php
                                    $statusMap = [
                                        'submitted' => 'Menunggu',
                                        'suggested' => 'Rekomendasi Siap',
                                        'in_progress' => 'Sedang Berlangsung',
                                        'completed' => 'Selesai'
                                    ];
                                    $statusLabel = $statusMap[$c['status']] ?? $c['status'];
                                    $statusClass = 'status-' . ($c['status'] ?? 'default');
                                    ?>
                                    <span class="status-badge <?= htmlspecialchars($statusClass, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <?php if ($c['status'] === 'suggested'): ?>
                                        <a href="?page=consultation_feedback&id=<?= (int) $c['id'] ?>" class="btn-feedback">
                                            Feedback
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($c['status'] !== 'completed'): ?>
                                        <a href="?page=consultation_chat&id=<?= (int) $c['id'] ?>" class="btn-chat">
                                            💬 Chat
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="d-flex gap-2 flex-wrap">
            <a href="?page=landing" class="btn-secondary-custom">Kembali</a>
            <a href="?page=consultation_form" class="btn-success-custom">+ Konsultasi Baru</a>
        </div>
    </div>
</body>

</html>