<?php // app/views/checkout/form.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    $_SESSION['error'] = "Keranjang kosong.";
    header('Location: ?page=cart');
    exit;
}

// Hitung total produk (tanpa ongkir) dan berat total
$productTotal = 0;
$totalWeight = 0; // dalam gram
foreach ($cart as $item) {
    $price = $item['price'];
    $discount = isset($item['discount']) ? (float) $item['discount'] : 0;
    $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
    $productTotal += $finalPrice * $item['qty'];

    // Hitung berat (asumsi 300 gram per item jika tidak ada data berat)
    $itemWeight = isset($item['weight']) ? (int) $item['weight'] : 300;
    $totalWeight += $itemWeight * $item['qty'];
}
// Konversi ke kg untuk ditampilkan (dibulatkan ke atas)
$displayWeight = ceil($totalWeight / 1000);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | Ruang Rasa</title>

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

        .checkout-header {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: var(--dark-grey);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkout-card,
        .summary-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-grey);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.15);
            outline: none;
        }

        .form-check-input:checked {
            background-color: var(--soft-blue);
            border-color: var(--soft-blue);
        }

        .btn-checkout {
            background: white;
            color: var(--soft-blue);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            box-shadow: 0 4px 12px rgba(121, 161, 191, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .btn-checkout:hover:not(:disabled) {
            background-color: var(--soft-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(121, 161, 191, 0.4);
        }

        .btn-checkout:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: var(--dark-grey);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: var(--dark-grey);
            display: block;
        }

        .item-detail {
            font-size: 0.85rem;
            color: #777;
            margin-top: 0.25rem;
        }

        .total-row {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--soft-blue);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid var(--off-white);
            display: flex;
            justify-content: space-between;
        }

        .form-text {
            font-size: 0.85rem;
            color: #777;
            margin-top: 0.25rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--soft-blue);
            text-decoration: none;
        }

        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(121, 161, 191, 0.3);
            border-radius: 50%;
            border-top-color: var(--soft-blue);
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            color: var(--soft-blue);
            font-style: italic;
            margin-top: 4px;
            font-size: 0.85rem;
            display: none;
        }

        .weight-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 8px 12px;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .district-note {
            background-color: #e3f2fd;
            border-left: 4px solid var(--soft-blue);
            padding: 8px 12px;
            margin-top: 8px;
            font-size: 0.85rem;
            border-radius: 0 4px 4px 0;
        }

        /* Error message style */
        .alert {
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Responsif */
        @media (max-width: 768px) {

            .checkout-card,
            .summary-card {
                padding: 1.5rem;
            }

            .btn-checkout {
                font-size: 1rem;
            }

            .summary-card {
                margin-top: 2rem;
            }

            .row {
                --bs-gutter-x: 1rem;
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
                <li class="breadcrumb-item"><a href="?page=cart">Keranjang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <h1 class="checkout-header">
            <i class="fas fa-receipt" aria-hidden="true"></i> Konfirmasi Pesanan
        </h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Form Checkout -->
            <div class="col-lg-7">
                <div class="checkout-card">
                    <form id="checkout-form" method="post" action="?page=checkout_process" novalidate>
                        <!-- Hidden inputs -->
                        <input type="hidden" id="product_total" value="<?= (int) $productTotal ?>">
                        <input type="hidden" name="province_name" id="province_name">
                        <input type="hidden" name="city_name" id="city_name">
                        <input type="hidden" name="district_name" id="district_name">
                        <input type="hidden" name="subdistrict_name" id="subdistrict_name">
                        <input type="hidden" name="shipping_courier" id="shipping_courier">
                        <input type="hidden" name="shipping_cost" id="shipping_cost">
                        <input type="hidden" name="total_weight" value="<?= $totalWeight ?>">

                        <div class="mb-4">
                            <label for="recipient_name" class="form-label">Nama Penerima</label>
                            <input type="text" id="recipient_name" name="recipient_name" class="form-control" required
                                placeholder="Siapa yang akan menerima hadiah ini?"
                                value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                aria-describedby="recipient-help">
                            <div id="recipient-help" class="form-text">Pastikan nama sesuai KTP atau identitas resmi
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="shipping_address" class="form-label">Alamat Pengiriman Lengkap</label>
                            <textarea id="shipping_address" name="shipping_address" class="form-control" rows="3"
                                required placeholder="Contoh: Jl. Mawar No. 10, RT 01/RW 02"
                                aria-describedby="address-help"><?= htmlspecialchars($_POST['shipping_address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            <div id="address-help" class="form-text">Masukkan detail alamat termasuk RT/RW dan nomor
                                rumah
                            </div>
                        </div>

                        <h4 class="mb-3">Informasi Pengiriman</h4>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="province" class="form-label">Provinsi</label>
                                <select id="province" class="form-select" aria-describedby="province-help">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <div class="loading-text" id="province-loading">
                                    <span class="spinner"></span> Memuat data...
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">Kota / Kabupaten</label>
                                <select id="city" name="shipping_city" class="form-select" disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                                <div class="loading-text" id="city-loading">
                                    <span class="spinner"></span> Memuat data...
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="district" class="form-label">Kecamatan</label>
                                <select id="district" class="form-select" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                <div class="loading-text" id="district-loading">
                                    <span class="spinner"></span> Memuat data...
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="subdistrict" class="form-label">Kelurahan / Desa</label>
                                <select id="subdistrict" name="subdistrict_id" class="form-select" disabled>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                                <div class="loading-text" id="subdistrict-loading">
                                    <span class="spinner"></span> Memuat data...
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="courier" class="form-label">Kurir</label>
                                <select id="courier" class="form-select">
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS Indonesia</option>
                                    <option value="sicepat">SiCepat</option>
                                    <option value="j&t">J&T Express</option>
                                    <option value="anteraja">AnterAja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="service" class="form-label">Layanan</label>
                                <select id="service" class="form-select" disabled>
                                    <option value="">Pilih Layanan</option>
                                </select>
                                <div class="loading-text" id="cost-loading">
                                    <span class="spinner"></span> Menghitung ongkos kirim...
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Total Ongkir:</strong>
                                <span id="ongkir_total" class="fs-5 fw-bold text-primary">Rp0</span>
                            </div>
                            <div class="weight-info">
                                <i class="fas fa-weight me-1"></i> Perkiraan berat paket: <?= $displayWeight ?> kg
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Metode Pembayaran</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="transfer" id="pm2"
                                        class="form-check-input" required>
                                    <label class="form-check-label" for="pm2">
                                        <i class="fas fa-university me-2" aria-hidden="true"></i> Transfer Bank (BCA,
                                        BNI, Mandiri)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="ewallet" id="pm3"
                                        class="form-check-input" required>
                                    <label class="form-check-label" for="pm3">
                                        <i class="fas fa-wallet me-2" aria-hidden="true"></i> E-Wallet (GoPay, OVO,
                                        DANA)
                                    </label>
                                </div>
                            </div>
                            <div class="form-text">Pilih salah satu metode pembayaran</div>
                        </div>

                        <button type="submit" class="btn-checkout" id="checkout-btn" disabled>
                            <i class="fas fa-check-circle me-2" aria-hidden="true"></i>
                            Bayar & Kirim Kejutan — <span id="btn-total">Rp
                                <?= number_format($productTotal, 0, ',', '.') ?></span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-lg-5">
                <div class="summary-card sticky-top" style="top: 20px;">
                    <h5 class="summary-title">Ringkasan Pesanan</h5>
                    <div class="summary-items">
                        <?php foreach ($cart as $it):
                            $price = $it['price'];
                            $discount = $it['discount'] ?? 0;
                            $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
                            $itemWeight = isset($it['weight']) ? (int) $it['weight'] : 300;
                            ?>
                            <div class="summary-item">
                                <div>
                                    <span class="item-name"><?= htmlspecialchars($it['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <small class="text-muted d-block mt-1">
                                        Qty: <?= (int) $it['qty'] ?> •
                                        Berat: <?= $itemWeight * $it['qty'] ?> gram
                                    </small>
                                    <?php if (!empty($it['custom_text'])): ?>
                                        <div class="item-detail mt-1">
                                            <i class="fas fa-tag me-1"></i>
                                            "<?= htmlspecialchars($it['custom_text'], ENT_QUOTES, 'UTF-8') ?>"
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="fw-bold">Rp <?= number_format($finalPrice * $it['qty'], 0, ',', '.') ?></div>
                            </div>
                        <?php endforeach; ?>

                        <div class="summary-item mt-3">
                            <div>
                                <span class="item-name">Total Produk</span>
                                <div class="item-detail">Berat Total: <?= $totalWeight ?> gram (<?= $displayWeight ?>
                                    kg)</div>
                            </div>
                            <div class="fw-bold">Rp <?= number_format($productTotal, 0, ',', '.') ?></div>
                        </div>

                        <div class="summary-item">
                            <span class="item-name">Ongkos Kirim</span>
                            <span id="summary-shipping">Rp 0</span>
                        </div>
                    </div>
                    <div class="total-row mt-3">
                        <span>Total Pembayaran</span>
                        <span id="summary-total" class="text-primary">Rp
                            <?= number_format($productTotal, 0, ',', '.') ?></span>
                    </div>
                    <div class="mt-3 text-center text-muted small">
                        <i class="fas fa-shield-alt me-1"></i> Pesanan diproses setelah pembayaran dikonfirmasi
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // --- Elemen DOM ---
            const provinceSelect = document.querySelector("#province");
            const citySelect = document.querySelector("#city");
            const districtSelect = document.querySelector("#district");
            const subdistrictSelect = document.querySelector("#subdistrict");
            const courierSelect = document.querySelector("#courier");
            const serviceSelect = document.querySelector("#service");
            const ongkirTotalEl = document.querySelector("#ongkir_total");
            const btnTotalEl = document.querySelector("#btn-total");
            const summaryTotalEl = document.querySelector("#summary-total");
            const summaryShippingEl = document.querySelector("#summary-shipping");
            const checkoutBtn = document.querySelector("#checkout-btn");
            const productTotal = parseInt(document.getElementById('product_total').value);
            const form = document.getElementById('checkout-form');
            const totalWeight = <?= $totalWeight ?>; // Total berat dalam gram

            // Loading elements
            const provinceLoading = document.getElementById('province-loading');
            const cityLoading = document.getElementById('city-loading');
            const districtLoading = document.getElementById('district-loading');
            const subdistrictLoading = document.getElementById('subdistrict-loading');
            const costLoading = document.getElementById('cost-loading');

            // Hidden inputs for location names
            const provinceNameInput = document.getElementById('province_name');
            const cityNameInput = document.getElementById('city_name');
            const districtNameInput = document.getElementById('district_name');
            const subdistrictNameInput = document.getElementById('subdistrict_name');

            // Reset select helper
            function resetSelect(selectElement, placeholderText, disable = true) {
                selectElement.innerHTML = `<option value="">${placeholderText}</option>`;
                selectElement.disabled = disable;
                if (selectElement === serviceSelect) {
                    ongkirTotalEl.innerText = "Rp0";
                    summaryShippingEl.innerText = "Rp0";
                    updateFinalTotal(0);
                }
            }

            // Toggle loading indicator
            function toggleLoading(element, show) {
                if (element) {
                    element.style.display = show ? 'block' : 'none';
                }
            }

            // Initialize selects
            resetSelect(citySelect, "Pilih Kota/Kabupaten");
            resetSelect(districtSelect, "Pilih Kecamatan");
            resetSelect(subdistrictSelect, "Pilih Kelurahan/Desa");
            resetSelect(serviceSelect, "Pilih Layanan");

            // Load provinces
            toggleLoading(provinceLoading, true);
            provinceSelect.innerHTML = `<option value="">Memuat Provinsi...</option>`;
            fetch("?page=shipping_provinces")
                .then(res => res.json())
                .then(res => {
                    toggleLoading(provinceLoading, false);
                    provinceSelect.innerHTML = "<option value=''>Pilih Provinsi</option>";
                    if (res.data?.length) {
                        res.data.forEach(p => {
                            provinceSelect.innerHTML += `<option value="${p.province_id}">${p.province}</option>`;
                        });
                    } else {
                        provinceSelect.innerHTML = "<option value=''>Tidak ada data provinsi</option>";
                    }
                })
                .catch(err => {
                    console.error("Error loading provinces:", err);
                    toggleLoading(provinceLoading, false);
                    provinceSelect.innerHTML = `<option value="">Gagal memuat provinsi</option>`;
                });

            provinceSelect.addEventListener("change", function () {
                const provId = this.value;
                resetSelect(citySelect, "Memuat Kota...");
                resetSelect(districtSelect, "Pilih Kecamatan");
                resetSelect(subdistrictSelect, "Pilih Kelurahan");
                resetSelect(serviceSelect, "Pilih Layanan");
                provinceNameInput.value = provId ? this.options[this.selectedIndex].text : '';

                if (!provId) {
                    cityNameInput.value = '';
                    districtNameInput.value = '';
                    subdistrictNameInput.value = '';
                    return;
                }

                toggleLoading(cityLoading, true);
                fetch(`?page=shipping_cities&province_id=${provId}`)
                    .then(res => res.json())
                    .then(res => {
                        toggleLoading(cityLoading, false);
                        citySelect.innerHTML = "<option value=''>Pilih Kota/Kabupaten</option>";
                        if (res.data?.length) {
                            res.data.forEach(c => {
                                citySelect.innerHTML += `<option value="${c.city_id}">${c.type} ${c.city_name}</option>`;
                            });
                            citySelect.disabled = false;
                        } else {
                            citySelect.innerHTML = "<option value=''>Tidak ada kota tersedia</option>";
                        }
                    })
                    .catch(err => {
                        console.error("Error loading cities:", err);
                        toggleLoading(cityLoading, false);
                        resetSelect(citySelect, "Error memuat kota");
                    });
            });

            citySelect.addEventListener("change", function () {
                const cityId = this.value;
                resetSelect(districtSelect, "Memuat Kecamatan...");
                resetSelect(subdistrictSelect, "Pilih Kelurahan");
                resetSelect(serviceSelect, "Pilih Layanan");
                cityNameInput.value = cityId ? this.options[this.selectedIndex].text : '';

                if (!cityId) {
                    districtNameInput.value = '';
                    subdistrictNameInput.value = '';
                    return;
                }

                toggleLoading(districtLoading, true);
                fetch(`?page=shipping_districts&city_id=${cityId}`)
                    .then(res => res.json())
                    .then(res => {
                        toggleLoading(districtLoading, false);
                        districtSelect.innerHTML = "<option value=''>Pilih Kecamatan</option>";
                        if (res.data?.length) {
                            res.data.forEach(d => {
                                districtSelect.innerHTML += `<option value="${d.district_id}">${d.district_name}</option>`;
                            });
                            districtSelect.disabled = false;
                        } else {
                            districtSelect.innerHTML = "<option value=''>Tidak ada kecamatan tersedia</option>";
                        }
                    })
                    .catch(err => {
                        console.error("Error loading districts:", err);
                        toggleLoading(districtLoading, false);
                        resetSelect(districtSelect, "Error memuat kecamatan");
                    });
            });

            districtSelect.addEventListener("change", function () {
                const districtId = this.value;
                resetSelect(subdistrictSelect, "Memuat Kelurahan...");
                resetSelect(serviceSelect, "Pilih Layanan");
                districtNameInput.value = districtId ? this.options[this.selectedIndex].text : '';

                if (!districtId) {
                    subdistrictNameInput.value = '';
                    return;
                }

                toggleLoading(subdistrictLoading, true);
                fetch(`?page=shipping_subdistricts&district_id=${districtId}`)
                    .then(res => res.json())
                    .then(res => {
                        toggleLoading(subdistrictLoading, false);
                        subdistrictSelect.innerHTML = "<option value=''>Pilih Kelurahan/Desa</option>";
                        if (res.data?.length) {
                            res.data.forEach(s => {
                                subdistrictSelect.innerHTML += `<option value="${s.subdistrict_id}">${s.subdistrict_name}</option>`;
                            });
                            subdistrictSelect.disabled = false;
                        } else {
                            subdistrictSelect.innerHTML = "<option value=''>Tidak ada kelurahan tersedia</option>";
                        }
                    })
                    .catch(err => {
                        console.error("Error loading subdistricts:", err);
                        toggleLoading(subdistrictLoading, false);
                        resetSelect(subdistrictSelect, "Error memuat kelurahan");
                    });
            });

            subdistrictSelect.addEventListener("change", function () {
                subdistrictNameInput.value = this.value ? this.options[this.selectedIndex].text : '';
                if (this.value && courierSelect.value) {
                    calculateCost();
                }
            });

            function calculateCost() {
                const destination = subdistrictSelect.value;
                const courier = courierSelect.value;

                if (!destination || !courier) {
                    resetSelect(serviceSelect, "Pilih Kurir & Kelurahan");
                    return;
                }

                toggleLoading(costLoading, true);
                resetSelect(serviceSelect, "Menghitung Ongkir...");

                const form = new FormData();
                form.append("destination", destination);
                form.append("weight", totalWeight); // Total weight dalam gram
                form.append("courier", courier);


                fetch("?page=shipping_cost", {
                    method: "POST",
                    body: form
                })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok: ' + res.status);
                        }
                        return res.json();
                    })
                    .then(res => {
                        toggleLoading(costLoading, false);

                        if (!res.success || !Array.isArray(res.data) || res.data.length === 0) {
                            throw new Error(res.message || 'Tidak ada layanan pengiriman tersedia');
                        }

                        serviceSelect.innerHTML = "";
                        res.data.forEach(item => {
                            const cost = item.cost;
                            const etd = item.etd.replace('hari', 'hari').trim(); // Normalisasi format

                            serviceSelect.innerHTML += `
                <option value="${cost}" data-service="${item.service}" data-etd="${etd}">
                    ${item.service} - Rp${new Intl.NumberFormat('id-ID').format(cost)} (${etd})
                </option>
            `;
                        });

                        serviceSelect.disabled = false;
                        serviceSelect.selectedIndex = 1; // Pilih opsi pertama
                        serviceSelect.dispatchEvent(new Event('change'));
                    })
                    .catch(err => {
                        toggleLoading(costLoading, false);

                        // Fallback ke district jika subdistrict gagal
                        if (subdistrictSelect.value && districtSelect.value !== subdistrictSelect.value) {
                            console.log("Subview cost failed, trying district fallback:", err.message);

                            const fallbackForm = new FormData();
                            fallbackForm.append("destination", districtSelect.value);
                            fallbackForm.append("weight", totalWeight);
                            fallbackForm.append("courier", courier);

                            fetch("?page=shipping_cost", {
                                method: "POST",
                                body: fallbackForm
                            })
                                .then(res => res.json())
                                .then(fallbackRes => {
                                    if (fallbackRes.success && fallbackRes.data?.length) {
                                        serviceSelect.innerHTML = "";
                                        fallbackRes.data.forEach(item => {
                                            const cost = item.cost;
                                            const etd = item.etd.replace('hari', 'hari').trim();

                                            serviceSelect.innerHTML += `
                            <option value="${cost}" data-service="${item.service}" data-etd="${etd}">
                                ${item.service} - Rp${new Intl.NumberFormat('id-ID').format(cost)} (${etd})
                            </option>
                        `;
                                        });
                                        serviceSelect.disabled = false;
                                        serviceSelect.selectedIndex = 1;
                                        serviceSelect.dispatchEvent(new Event('change'));
                                        console.log("District fallback successful");
                                    } else {
                                        handleCostError(err.message);
                                    }
                                })
                                .catch(fallbackErr => {
                                    console.error("District fallback also failed:", fallbackErr);
                                    handleCostError(err.message + " | Fallback gagal: " + fallbackErr.message);
                                });
                            return;
                        }

                        handleCostError(err.message);
                    });
            }

            function handleCostError(message) {
                resetSelect(serviceSelect, "Error");
                serviceSelect.innerHTML = `<option value="">${message || 'Gagal menghitung ongkir'}</option>`;
                alert(`🚫 Gagal menghitung ongkos kirim:\n${message || 'Silakan coba lagi atau hubungi admin'}`);
            }

            courierSelect.addEventListener("change", function () {
                if (subdistrictSelect.value) {
                    calculateCost();
                } else {
                    resetSelect(serviceSelect, "Pilih Alamat Dulu");
                }
            });

            serviceSelect.addEventListener("change", function () {
                const cost = this.value ? parseInt(this.value) : 0;
                const service = this.selectedOptions[0]?.dataset.service || '';
                const etd = this.selectedOptions[0]?.dataset.etd || '?';

                document.querySelector("#shipping_courier").value = cost ? (courierSelect.value.toUpperCase() + " - " + service) : "";
                document.querySelector("#shipping_cost").value = cost;

                // Format ongkir dengan pemisah ribuan
                const formattedCost = new Intl.NumberFormat('id-ID').format(cost);
                ongkirTotalEl.innerText = "Rp" + formattedCost;
                summaryShippingEl.innerText = "Rp" + formattedCost;

                updateFinalTotal(cost);

                // Aktifkan tombol checkout jika semua data lengkap
                checkFormCompleteness();
            });

            function updateFinalTotal(shippingCost) {
                const final = productTotal + shippingCost;
                const formattedTotal = new Intl.NumberFormat('id-ID').format(final);

                btnTotalEl.textContent = "Rp" + formattedTotal;
                summaryTotalEl.textContent = "Rp" + formattedTotal;
            }

            function checkFormCompleteness() {
                const isAddressComplete =
                    provinceSelect.value &&
                    citySelect.value &&
                    districtSelect.value &&
                    subdistrictSelect.value;

                const isShippingComplete =
                    courierSelect.value &&
                    serviceSelect.value &&
                    parseInt(document.getElementById('shipping_cost').value) > 0;

                const isPaymentSelected =
                    document.querySelector('input[name="payment_method"]:checked');

                checkoutBtn.disabled = !(isAddressComplete && isShippingComplete && isPaymentSelected);
            }

            // Event listeners untuk validasi real-time
            [provinceSelect, citySelect, districtSelect, subdistrictSelect, courierSelect, serviceSelect].forEach(select => {
                select.addEventListener('change', checkFormCompleteness);
            });

            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', checkFormCompleteness);
            });

            form.addEventListener('submit', function (e) {
                // Validasi manual untuk memastikan semua field terisi
                const shippingCost = parseInt(document.getElementById('shipping_cost').value) || 0;
                if (shippingCost <= 0) {
                    alert('Silakan pilih layanan pengiriman terlebih dahulu.');
                    e.preventDefault();
                    return false;
                }

                if (!provinceSelect.value || !citySelect.value || !districtSelect.value || !subdistrictSelect.value) {
                    alert('Silakan lengkapi alamat pengiriman (Provinsi, Kota, Kecamatan, dan Kelurahan).');
                    e.preventDefault();
                    return false;
                }

                if (!document.querySelector('input[name="payment_method"]:checked')) {
                    alert('Silakan pilih metode pembayaran.');
                    e.preventDefault();
                    return false;
                }

                // Tampilkan loading saat submit
                checkoutBtn.disabled = true;
                checkoutBtn.innerHTML = '<span class="spinner"></span> Memproses pesanan...';
            });

            // Auto-focus ke provinsi saat halaman dimuat
            setTimeout(() => {
                provinceSelect.focus();
            }, 300);
        });
    </script>
</body>

</html>
