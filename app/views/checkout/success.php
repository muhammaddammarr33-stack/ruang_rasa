<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

$orderId = $_GET['id'] ?? null;

// load midtrans config
$config = require __DIR__ . '/../../../app/config_midtrans.php';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $config['client_key'] ?>">
    </script>

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

        .success-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            max-width: 600px;
            margin: 3rem auto;
            text-align: center;
        }

        .check-icon {
            width: 80px;
            height: 80px;
            background: rgba(119, 193, 143, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #4caf50;
            font-size: 2.2rem;
        }

        .success-title {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark-grey);
            margin-bottom: 1rem;
        }

        .order-id {
            background: rgba(121, 161, 191, 0.08);
            color: var(--soft-blue);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 1rem 0;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            font-size: 1.05rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-primary:hover {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .note {
            font-size: 0.95rem;
            color: var(--dark-grey);
            opacity: 0.85;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px dashed #eee;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="success-card">

            <div class="check-icon">
                <i class="fas fa-check"></i>
            </div>

            <h1 class="success-title">Pesananmu Berhasil Dibuat 💞</h1>

            <p class="success-message">
                Terima kasih! Pesanan kamu sudah masuk ke sistem kami.
                Silakan lanjutkan pembayaran ya.
            </p>

            <?php if ($orderId): ?>
                <p class="text-muted mb-2">Nomor pesanan:</p>
                <div class="order-id">#<?= htmlspecialchars($orderId) ?></div>

                <!-- TOMBOL BAYAR SEKARANG -->
                <button id="pay-button" class="btn btn-primary mt-3">
                    <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                </button>

                <!-- Link lihat riwayat -->
                <a href="?page=orders" class="btn btn-secondary mt-3 d-block">
                    <i class="fas fa-list me-2"></i> Lihat Riwayat Pesanan
                </a>

            <?php else: ?>
                <p class="text-muted">Pesanan berhasil diproses.</p>
                <a href="?page=landing" class="btn btn-secondary mt-3">
                    <i class="fas fa-home me-2"></i> Kembali ke Beranda
                </a>
            <?php endif; ?>

            <p class="note">
                Setelah pembayaran, status pesanan akan diperbarui secara otomatis.
            </p>
        </div>
    </div>

    <?php if ($orderId): ?>
        <script>
            document.getElementById('pay-button').onclick = function () {

                fetch('?page=get_snap_token', {
                    method: 'POST',
                    body: new URLSearchParams({ order_id: <?= $orderId ?> })
                })
                    .then(res => res.json())
                    .then(data => {

                        snap.pay(data.token, {

                            onSuccess: function (result) {
                                saveTransaction(result);
                            },

                            onPending: function (result) {
                                saveTransaction(result);
                            },

                            onError: function (result) {
                                saveTransaction(result);
                            }

                        });
                    });

            };

            function saveTransaction(result) {
                fetch('?page=save_transaction', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        order_id: <?= $orderId ?>,
                        transaction_id: result.transaction_id,
                        payment_type: result.payment_type,
                        status: result.transaction_status
                    })
                })
                    .then(() => {
                        window.location.href = "?page=payment_verify&id=<?= $orderId ?>";
                    });
            }
        </script>
    <?php endif; ?>

</body>

</html>