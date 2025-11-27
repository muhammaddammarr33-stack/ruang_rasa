<?php
require_once __DIR__ . '/../../models/Memberships.php';
$ms = new Memberships();
$membership = $ms->get($_SESSION['user']['id']);
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya | Ruang Rasa</title>

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
            padding: 1.5rem 0;
        }

        .profile-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
        }

        .profile-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-control:disabled {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .btn-save {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-save:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .btn-logout {
            background-color: var(--soft-peach);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-logout:hover {
            background-color: #d89484;
        }

        .profile-image-wrapper {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--soft-blue);
            margin-bottom: 1rem;
        }

        .membership-card {
            background: rgba(121, 161, 191, 0.06);
            border: 1px solid rgba(121, 161, 191, 0.2);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .membership-card h5 {
            margin-bottom: 0.75rem;
            color: var(--soft-blue);
            font-weight: 700;
        }

        .membership-card p {
            margin-bottom: 0.35rem;
            font-size: 0.95rem;
        }

        .membership-tier {
            font-weight: 700;
            text-transform: uppercase;
            color: var(--dark-grey);
        }

        .membership-points {
            font-weight: 700;
            color: var(--soft-blue);
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

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border: none;
            color: #c0392b;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 1.5rem;
            }

            .btn-group-profile {
                flex-direction: column;
                gap: 0.75rem;
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
        <h3 class="profile-header">Profil Pengguna</h3>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert" aria-live="polite">
                <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert" aria-live="polite">
                <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <form method="POST" action="?page=profile_update" enctype="multipart/form-data" novalidate>

                <?= SecurityHelper::csrfInput(); ?>

                <!-- Foto Profil + Membership -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="profile-image-wrapper">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="<?= htmlspecialchars($user['profile_image'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="profile-image" alt="Foto profil Anda">
                            <?php else: ?>
                                <div class="profile-image d-flex align-items-center justify-content-center text-muted"
                                    style="background: #f5f5f5;">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="profile_image" class="form-control form-control-sm"
                                aria-label="Pilih foto profil baru">
                        </div>
                    </div>

                    <!-- <div class="col-md-9"> -->
                        <!-- Kartu Membership -->
                        <!-- <div class="membership-card"> -->
                            <!-- <h5>Membership</h5>
                            <p>
                                <strong>Tier:</strong>
                                <span
                                    class="membership-tier"><?= htmlspecialchars(strtoupper($membership['tier'] ?? 'Basic'), ENT_QUOTES, 'UTF-8') ?></span>
                            </p>
                            <p>
                                <strong>Poin:</strong>
                                <span class="membership-points"><?= number_format($membership['points'] ?? 0) ?></span>
                            </p>
                        </div>
                    </div>
                </div> -->

                <!-- Form Data Diri -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="name" name="name"
                                value="<?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                class="form-control" required aria-describedby="name-help">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email (tidak dapat diubah)</label>
                            <input type="email" id="email"
                                value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                class="form-control" disabled aria-describedby="email-help">
                            <div id="email-help" class="form-text">Email tidak bisa diubah untuk keamanan akun.</div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" id="phone" name="phone"
                                value="<?= htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                class="form-control" placeholder="Contoh: 081234567890">
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea id="address" name="address" class="form-control" rows="3"
                                placeholder="Alamat lengkap untuk pengiriman"><?= htmlspecialchars($user['address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="d-flex gap-3 btn-group-profile">
                            <button type="submit" class="btn-save" aria-label="Simpan perubahan profil">
                                Simpan Perubahan
                            </button>
                            <a href="?page=logout" class="btn-logout" aria-label="Keluar dari akun">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>