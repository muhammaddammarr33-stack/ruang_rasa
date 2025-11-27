<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konsultasi Kado | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --off-white: #F5F5EC;
            --soft-blue: #79A1BF;
            --dark-grey: #343D46;
        }

        body {
            background-color: var(--off-white);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-grey);
            padding: 1.5rem 0;
        }

        .consult-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark-grey);
        }

        .form-select,
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-right: 1rem;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            margin-right: 0.5rem;
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-submit {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            font-size: 1.05rem;
            transition: background-color 0.2s, transform 0.2s;
            cursor: pointer;
        }

        .btn-submit:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-2px);
        }

        .interests-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 0.5rem;
        }

        @media (max-width: 576px) {
            .consult-card {
                padding: 1.5rem;
            }

            .form-check {
                flex: 1 0 45%;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="consult-card">
            <h3 class="mb-2">🎁 Konsultasi Kado Personal</h3>
            <p class="text-muted mb-4">Bantu kami memahami kebutuhan Anda agar rekomendasi lebih tepat.</p>

            <form method="post" action="?page=consultation_create" id="consultForm" novalidate>

                <!-- Penerima -->
                <div class="mb-3">
                    <label for="recipient" class="form-label">Untuk siapa kado ini?</label>
                    <select name="recipient" id="recipient" class="form-select" required
                        aria-describedby="recipient-help">
                        <option value="">Pilih...</option>
                        <option value="Pasangan">Pasangan</option>
                        <option value="Orang Tua">Orang Tua</option>
                        <option value="Anak">Anak</option>
                        <option value="Teman">Teman</option>
                        <option value="Rekan Kerja">Rekan Kerja</option>
                        <option value="Diri Sendiri">Diri Sendiri</option>
                    </select>
                </div>

                <!-- Acara -->
                <div class="mb-3">
                    <label for="occasion" class="form-label">Acara apa?</label>
                    <select name="occasion" id="occasion" class="form-select" required>
                        <option value="">Pilih...</option>
                        <option value="Ulang Tahun">Ulang Tahun</option>
                        <option value="Anniversary">Anniversary</option>
                        <option value="Kelulusan">Kelulusan</option>
                        <option value="Natal">Natal</option>
                        <option value="Lebaran">Lebaran</option>
                        <option value="Tanpa Acara">Tidak Ada Acara Spesial</option>
                    </select>
                </div>

                <!-- Usia -->
                <div class="mb-3">
                    <label for="age_range" class="form-label">Rentang usia penerima?</label>
                    <select name="age_range" id="age_range" class="form-select" required>
                        <option value="">Pilih...</option>
                        <option value="<12">
                            < 12 tahun</option>
                        <option value="13-17">13 - 17 tahun</option>
                        <option value="18-25">18 - 25 tahun</option>
                        <option value="26-40">26 - 40 tahun</option>
                        <option value=">40">> 40 tahun</option>
                    </select>
                </div>

                <!-- Hobi/Minat -->
                <div class="mb-4">
                    <label class="form-label">Apa hobi/minat penerima? (boleh pilih lebih dari satu)</label>
                    <div class="interests-wrapper">
                        <?php
                        $interests = ['Teknologi', 'Membaca', 'Memasak', 'Olahraga', 'Fashion', 'Musik', 'Travel', 'Seni', 'Game', 'Kecantikan'];
                        foreach ($interests as $int):
                            $safeId = preg_replace('/[^a-zA-Z0-9]/', '_', $int);
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="interests[]"
                                    value="<?= htmlspecialchars($int, ENT_QUOTES, 'UTF-8') ?>" id="int_<?= $safeId ?>">
                                <label class="form-check-label"
                                    for="int_<?= $safeId ?>"><?= htmlspecialchars($int, ENT_QUOTES, 'UTF-8') ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Anggaran -->
                <div class="mb-4">
                    <label for="budget_range" class="form-label">Berapa anggaran Anda?</label>
                    <select name="budget_range" id="budget_range" class="form-select" required>
                        <option value="">Pilih...</option>
                        <option value="<100rb">
                            < Rp 100.000</option>
                        <option value="100-300rb">Rp 100.000 - 300.000</option>
                        <option value="300-500rb">Rp 300.000 - 500.000</option>
                        <option value=">500rb">> Rp 500.000</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit" aria-label="Dapatkan rekomendasi kado">
                    Dapatkan Rekomendasi
                </button>
            </form>
        </div>
    </div>
</body>

</html>