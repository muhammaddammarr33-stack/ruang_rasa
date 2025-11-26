<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback Konsultasi | Ruang Rasa</title>

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
        }

        body {
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            padding: 1rem 0;
        }

        .feedback-card,
        .suggestion-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .feedback-card .card-body {
            padding: 1.5rem;
        }

        .suggestion-card {
            height: 100%;
            border: 1px solid #f0f0f0;
        }

        .suggestion-card .card-body {
            padding: 1.25rem;
        }

        .suggestion-card h6 {
            font-weight: 600;
            color: var(--dark-grey);
            margin-bottom: 0.5rem;
        }

        .suggestion-card .text-muted {
            font-weight: 600;
            color: var(--soft-blue);
            margin-bottom: 0.75rem;
        }

        .form-check-input:checked {
            background-color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .form-check-label {
            font-weight: 500;
            line-height: 1.5;
        }

        .btn-submit {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-submit:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .section-divider {
            margin: 2rem 0;
        }

        @media (max-width: 768px) {

            .feedback-card .card-body,
            .suggestion-card .card-body {
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h3 class="mb-4">💬 Feedback Konsultasi</h3>

        <!-- Detail Konsultasi -->
        <div class="feedback-card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-2">Untuk:
                    <?= htmlspecialchars($consultation['recipient'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </h5>
                <p class="mb-1"><strong>Acara:</strong>
                    <?= htmlspecialchars($consultation['occasion'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
                <p class="mb-1"><strong>Usia:</strong>
                    <?= htmlspecialchars($consultation['age_range'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
                <p class="mb-1">
                    <strong>Minat:</strong>
                    <?php
                    $interests = !empty($consultation['interests']) ? json_decode($consultation['interests'], true) : false;
                    echo $interests ? htmlspecialchars(implode(', ', $interests), ENT_QUOTES, 'UTF-8') : '-';
                    ?>
                </p>
                <p class="mb-0"><strong>Anggaran:</strong>
                    <?= htmlspecialchars($consultation['budget_range'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <!-- Rekomendasi Produk -->
        <h5 class="mb-3">💡 Rekomendasi Produk</h5>
        <?php if ($suggestions): ?>
            <div class="row mt-3">
                <?php foreach ($suggestions as $s): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h6><?= htmlspecialchars($s['product_name']) ?></h6>
                                <p class="text-danger fw-bold">Rp <?= number_format($s['price'], 0, ',', '.') ?></p>
                                <p class="text-muted flex-grow-1"><?= htmlspecialchars($s['reason']) ?></p>

                                <!-- Form Tambah ke Keranjang -->
                                <form method="post" action="?page=add_to_cart" class="mt-auto">
                                    <input type="hidden" name="id" value="<?= $s['product_id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 mb-1">
                                        ➕ Tambah ke Keranjang
                                    </button>
                                </form>

                                <!-- Tombol Beli Sekarang -->
                                <a href="?page=checkout&product_id=<?= $s['product_id'] ?>"
                                    class="btn btn-outline-primary btn-sm w-100">
                                    💳 Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Belum ada rekomendasi.</p>
        <?php endif; ?>

        <div class="section-divider"></div>

        <!-- Form Feedback -->
        <h5 class="mb-3">🗣️ Apakah rekomendasi ini membantu?</h5>
        <form method="post"
            action="?page=consultation_feedback_submit&id=<?= htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <div class="mb-4">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="satisfaction" value="satisfied" id="sat"
                        required>
                    <label class="form-check-label" for="sat">✅ Ya, saya puas</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="satisfaction" value="unsatisfied" id="unsat"
                        required>
                    <label class="form-check-label" for="unsat">❌ Belum sesuai, saya butuh bantuan lebih lanjut</label>
                </div>
            </div>
            <button type="submit" class="btn-submit" aria-label="Kirim feedback">Kirim Feedback</button>
        </form>
    </div>
</body>

</html>