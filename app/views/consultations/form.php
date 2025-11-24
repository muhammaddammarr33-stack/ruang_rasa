<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Konsultasi Kado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4" style="max-width: 700px;">
        <h3 class="mb-4">🎁 Konsultasi Kado Personal</h3>
        <p class="text-muted mb-4">Bantu kami memahami kebutuhan Anda agar rekomendasi lebih tepat.</p>

        <form method="post" action="?page=consultation_create" id="consultForm">

            <!-- Penerima -->
            <div class="mb-3">
                <label class="form-label">Untuk siapa kado ini?</label>
                <select name="recipient" class="form-select" required>
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
                <label class="form-label">Acara apa?</label>
                <select name="occasion" class="form-select" required>
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
                <label class="form-label">Rentang usia penerima?</label>
                <select name="age_range" class="form-select" required>
                    <option value="">Pilih...</option>
                    <option value="<12">
                        < 12 tahun</option>
                    <option value="13-17">13 - 17 tahun</option>
                    <option value="18-25">18 - 25 tahun</option>
                    <option value="26-40">26 - 40 tahun</option>
                    <option value=">40">> 40 tahun</option>
                </select>
            </div>

            <!-- Hobi/Minat (Checkbox) -->
            <div class="mb-3">
                <label class="form-label">Apa hobi/minat penerima? (boleh pilih lebih dari satu)</label>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <?php
                    $interests = ['Teknologi', 'Membaca', 'Memasak', 'Olahraga', 'Fashion', 'Musik', 'Travel', 'Seni', 'Game', 'Kecantikan'];
                    foreach ($interests as $int):
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interests[]" value="<?= $int ?>"
                                id="int_<?= $int ?>">
                            <label class="form-check-label" for="int_<?= $int ?>"><?= $int ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Anggaran -->
            <div class="mb-4">
                <label class="form-label">Berapa anggaran Anda?</label>
                <select name="budget_range" class="form-select" required>
                    <option value="">Pilih...</option>
                    <option value="<100rb">
                        < Rp 100.000</option>
                    <option value="100-300rb">Rp 100.000 - 300.000</option>
                    <option value="300-500rb">Rp 300.000 - 500.000</option>
                    <option value=">500rb">> Rp 500.000</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"
                style="background-color: #79A1BF; border: none; border-radius: 12px; padding: 10px 24px;">
                Dapatkan Rekomendasi
            </button>
        </form>
    </div>
</body>

</html>