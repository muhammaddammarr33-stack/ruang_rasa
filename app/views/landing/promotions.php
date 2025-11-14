<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Promo Spesial | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
        }

        .promo-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            height: 100%;
        }

        .promo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .promo-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark-grey);
            margin-bottom: 1.5rem;
        }

        .discount-badge {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            font-weight: 700;
            padding: 0.35rem 0.8rem;
            border-radius: 12px;
            display: inline-block;
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }

        .promo-description {
            color: var(--dark-grey);
            opacity: 0.9;
            line-height: 1.6;
        }

        .promo-period {
            background-color: rgba(121, 161, 191, 0.08);
            color: var(--soft-blue);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-top: 0.75rem;
        }

        .btn-back {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .btn-back:hover {
            background-color: #658db2;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="promo-title">
                <i class="fas fa-bolt text-warning"></i> Promo Spesial
            </h2>
            <a href="?page=landing" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Beranda
            </a>
        </div>

        <?php if (empty($promos)): ?>
            <div class="text-center py-5">
                <i class="fas fa-gift fa-2x text-muted mb-3"></i>
                <p class="text-muted">Saat ini belum ada promo aktif.</p>
                <p class="text-muted">Cek kembali nanti — kami sering menghadirkan kejutan untuk pasangan LDR! 💞</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($promos as $p): ?>
                    <div class="col-md-4">
                        <div class="promo-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($p['name']) ?></h5>

                                <div class="discount-badge">
                                    Diskon <?= $p['discount'] ?>%
                                </div>

                                <p class="promo-description">
                                    <?= htmlspecialchars($p['description']) ?>
                                </p>

                                <div class="promo-period">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= date('d M Y', strtotime($p['start_date'])) ?>
                                    <i class="fas fa-arrow-right mx-1"></i>
                                    <?= date('d M Y', strtotime($p['end_date'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>