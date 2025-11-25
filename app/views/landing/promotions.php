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
            padding: 1.5rem 0;
        }

        .promo-header {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark-grey);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--dark-grey);
            margin-bottom: 1rem;
        }

        .discount-badge {
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            font-weight: 700;
            padding: 0.4rem 0.9rem;
            border-radius: 12px;
            display: inline-block;
            font-size: 1.15rem;
            margin: 0.5rem 0;
            letter-spacing: -0.02em;
        }

        .promo-description {
            color: var(--dark-grey);
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .promo-period {
            background-color: rgba(121, 161, 191, 0.08);
            color: var(--soft-blue);
            padding: 0.5rem 0.9rem;
            border-radius: 10px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back-home {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.4rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-back-home:hover {
            background-color: #658db2;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .promo-header {
                font-size: 1.6rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .promo-actions {
                width: 100%;
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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
            <h2 class="promo-header">
                <i class="fas fa-bolt text-warning" aria-hidden="true"></i> Promo Spesial
            </h2>
        </div>

        <?php if (empty($promos)): ?>
            <div class="text-center py-5">
                <i class="fas fa-gift fa-2x text-muted mb-3" aria-hidden="true"></i>
                <p class="text-muted">Saat ini belum ada promo aktif.</p>
                <p class="text-muted">Cek kembali nanti — kami sering menghadirkan kejutan untuk pasangan LDR! 💞</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($promos as $p): ?>
                    <div class="col-md-4">
                        <div class="promo-card" role="region" aria-labelledby="promo-title-<?= (int) $p['id'] ?>">
                            <div class="card-body">
                                <h5 id="promo-title-<?= (int) $p['id'] ?>" class="card-title">
                                    <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>
                                </h5>

                                <div class="discount-badge" aria-label="Diskon <?= (int) $p['discount'] ?> persen">
                                    Diskon <?= (int) $p['discount'] ?>%
                                </div>

                                <p class="promo-description">
                                    <?= htmlspecialchars($p['description'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <div class="promo-period"
                                    aria-label="Berlaku dari <?= htmlspecialchars(date('d M Y', strtotime($p['start_date'])), ENT_QUOTES, 'UTF-8') ?> hingga <?= htmlspecialchars(date('d M Y', strtotime($p['end_date'])), ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                    <?= htmlspecialchars(date('d M Y', strtotime($p['start_date'])), ENT_QUOTES, 'UTF-8') ?>
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    <?= htmlspecialchars(date('d M Y', strtotime($p['end_date'])), ENT_QUOTES, 'UTF-8') ?>
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