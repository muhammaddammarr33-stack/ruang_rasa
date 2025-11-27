<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Konsultasi</title>
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
            max-width: 800px;
        }

        h3,
        h5 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        h3 {
            font-size: 1.25rem;
        }

        h5 {
            font-size: 1rem;
            margin-top: 1.25rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border);
        }

        .detail-item {
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .badge {
            background-color: var(--accent);
            color: white;
            font-weight: 500;
            font-size: 0.8125rem;
            padding: 0.35em 0.6em;
        }

        .btn {
            font-size: 0.8125rem;
            padding: 0.375rem 0.625rem;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .btn-warning:hover {
            background-color: #ffecb5;
        }

        .btn-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .btn-success:hover {
            background-color: #bcd0c7;
        }

        .btn-info {
            background-color: #cff4fc;
            color: #055160;
            border: 1px solid #b6effb;
        }

        .btn-info:hover {
            background-color: #bfe2f2;
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: var(--dark);
            border: 1px solid #dee2e6;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
            margin-bottom: 1.25rem;
        }

        table {
            font-size: 0.875rem;
        }

        table th,
        table td {
            padding: 0.5rem;
        }

        table thead th {
            background-color: #fafafa;
            font-weight: 600;
            font-size: 0.8125rem;
        }

        .empty-state {
            color: var(--muted);
            font-style: italic;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>🧾 Detail Konsultasi #<?= $consultation['id'] ?></h3>

        <div class="detail-item"><strong>Penerima:</strong> <?= htmlspecialchars($consultation['recipient']) ?></div>
        <div class="detail-item"><strong>Acara:</strong> <?= htmlspecialchars($consultation['occasion']) ?></div>
        <div class="detail-item"><strong>Usia:</strong> <?= htmlspecialchars($consultation['age_range']) ?></div>
        <div class="detail-item"><strong>Minat:</strong>
            <?php
            $interests = json_decode($consultation['interests'], true);
            echo $interests ? implode(', ', array_map('htmlspecialchars', $interests)) : '-';
            ?>
        </div>
        <div class="detail-item"><strong>Anggaran:</strong> <?= htmlspecialchars($consultation['budget_range']) ?></div>
        <div class="detail-item"><strong>Status:</strong>
            <span class="badge"><?= ucfirst($consultation['status']) ?></span>
        </div>

        <div class="action-buttons">
            <a href="?page=admin_consultation_ai&id=<?= $consultation['id'] ?>" class="btn btn-warning">
                🤖 Generate AI Suggestion
            </a>
            <a href="?page=consultation_suggest&id=<?= $consultation['id'] ?>" class="btn btn-success">
                ➕ Manual Suggestion
            </a>
            <a href="?page=consultation_chat&id=<?= $consultation['id'] ?>" class="btn btn-info">
                💬 Buka Chat
            </a>
            <?php if ($consultation['status'] !== 'completed'): ?>
                <a href="?page=admin_consultation_done&id=<?= $consultation['id'] ?>" class="btn btn-secondary">
                    ✔ Tandai Selesai
                </a>
            <?php endif; ?>
        </div>

        <h5>💡 Rekomendasi Produk</h5>
        <?php if ($suggestions): ?>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Alasan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suggestions as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['product_name']) ?></td>
                            <td>Rp <?= number_format($s['price'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($s['reason']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($s['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-state">Belum ada rekomendasi.</p>
        <?php endif; ?>

        <h5>🗣️ Feedback User</h5>
        <?php if ($feedback): ?>
            <div class="detail-item"><strong>Kepuasan:</strong> <?= ucfirst(htmlspecialchars($feedback['satisfaction'])) ?>
            </div>
            <div class="detail-item"><strong>Follow Up:</strong> <?= $feedback['follow_up'] ? 'Ya' : 'Tidak' ?></div>
        <?php else: ?>
            <p class="empty-state">Belum ada feedback.</p>
        <?php endif; ?>

        <a href="?page=admin_consultations" class="btn btn-secondary mt-3">
            ⬅ Kembali
        </a>
    </div>
</body>

</html>