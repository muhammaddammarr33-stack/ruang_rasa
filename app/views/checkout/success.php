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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $config['client_key'] ?>"></script>

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

        .success-message {
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--dark-grey);
            opacity: 0.9;
            margin-bottom: 1.5rem;
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
            letter-spacing: 0.5px;
        }

        /* Custom Buttons — konsisten dengan sistem Ruang Rasa */
        .btn-primary-custom {
            background-color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            font-size: 1.05rem;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s, transform 0.2s;
            cursor: pointer;
        }

        .btn-primary-custom:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-secondary-custom {
            background-color: #f0f0f0;
            color: var(--dark-grey);
            border: none;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
            transition: background-color 0.2s;
        }

        .btn-secondary-custom:hover {
            background-color: #e0e0e0;
        }

        .note {
            font-size: 0.95rem;
            color: var(--dark-grey);
            opacity: 0.85;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px dashed #eee;
        }

        @media (max-width: 576px) {
            .success-card {
                padding: 2rem 1.5rem;
            }

            .btn-primary-custom,
            .btn-secondary-custom {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="success-card" role="alert" aria-live="polite">

            <div class="check-icon" aria-hidden="true">
                <i class="fas fa-check"></i>
            </div>

            <h1 class="success-title">Pesananmu Berhasil Dibuat 💞</h1>

            <p class="success-message">
                Terima kasih! Pesanan kamu sudah masuk ke sistem kami.<br>
                Silakan lanjutkan pembayaran ya.
            </p>

            <?php if ($orderId): ?>
                <p class="text-muted mb-2">Nomor pesanan:</p>
                <div class="order-id" aria-label="Nomor pesanan"><?= htmlspecialchars($orderId, ENT_QUOTES, 'UTF-8') ?>
                </div>

                <!-- TOMBOL BAYAR SEKARANG -->
                <button id="pay-button" class="btn-primary-custom mt-3" aria-label="Bayar sekarang">
                    <i class="fas fa-credit-card me-2" aria-hidden="true"></i> Bayar Sekarang
                </button>

            <?php else: ?>
                <p class="text-muted">Pesanan berhasil diproses.</p>
                <a href="?page=landing" class="btn-secondary-custom">
                    <i class="fas fa-home me-2" aria-hidden="true"></i> Kembali ke Beranda
                </a>
            <?php endif; ?>

            <p class="note">
                Setelah pembayaran, status pesanan akan diperbarui secara otomatis.
            </p>
        </div>
    </div>

    <?php if ($orderId): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('pay-button').onclick = function () {
                    fetch('?page=get_snap_token', {
                        method: 'POST',
                        body: new URLSearchParams({ order_id: <?= json_encode($orderId) ?> })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.token) {
                                alert('Gagal mendapatkan token pembayaran. Silakan coba lagi.');
                                return;
                            }

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
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            alert('Terjadi kesalahan saat memuat pembayaran. Silakan ulangi.');
                        });
                };

                function saveTransaction(result) {
                    fetch('?page=save_transaction', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            order_id: <?= json_encode($orderId) ?>,
                            transaction_id: result.transaction_id,
                            payment_type: result.payment_type,
                            status: result.transaction_status
                        })
                    })
                        .then(() => {
                            window.location.href = "?page=payment_verify&id=<?= urlencode($orderId) ?>";
                        })
                        .catch(err => {
                            console.error('Save transaction error:', err);
                            // Tetap redirect meski gagal simpan (Midtrans sudah menyimpan)
                            window.location.href = "?page=payment_verify&id=<?= urlencode($orderId) ?>";
                        });
                }
            });
        </script>
    <?php endif; ?>

</body>

</html>