<?php // app/views/checkout/form.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    $_SESSION['error'] = "Keranjang kosong.";
    header('Location: ?page=cart');
    exit;
}

// Hitung total produk (tanpa ongkir)
$productTotal = 0;
foreach ($cart as $item) {
    $price = $item['price'];
    $discount = isset($item['discount']) ? (float) $item['discount'] : 0;
    $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
    $productTotal += $finalPrice * $item['qty'];
}
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

        .checkout-card {
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
            background: linear-gradient(to right, var(--soft-blue), var(--soft-peach));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            box-shadow: 0 4px 12px rgba(121, 161, 191, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(121, 161, 191, 0.4);
        }

        .summary-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            height: fit-content;
        }

        .summary-title {
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: var(--dark-grey);
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: var(--dark-grey);
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
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--soft-blue);
            text-decoration: none;
        }

        @media (max-width: 768px) {

            .checkout-card,
            .summary-card {
                padding: 1.5rem;
            }

            .btn-checkout {
                font-size: 1rem;
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
            <i class="fas fa-receipt"></i> Konfirmasi Pesanan
        </h1>

        <div class="row g-4">
            <!-- Form Checkout -->
            <div class="col-md-7">
                <div class="checkout-card">
                    <form id="checkout-form" method="post" action="?page=checkout_process">
                        <!-- Hidden input for product total (used by JS) -->
                        <input type="hidden" id="product_total" value="<?= $productTotal ?>">

                        <!-- Hidden inputs for location names -->
                        <input type="hidden" name="province_name" id="province_name">
                        <input type="hidden" name="city_name" id="city_name">
                        <input type="hidden" name="district_name" id="district_name">

                        <div class="mb-4">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control" required
                                placeholder="Siapa yang akan menerima hadiah ini?"
                                value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Alamat Pengiriman Lengkap (Nomor, Jalan, Gedung, dll)</label>
                            <textarea name="shipping_address" class="form-control" rows="3" required
                                placeholder="Contoh: Jl. Mawar No. 10, Gedung Anggrek Lt. 3"><?= htmlspecialchars($_POST['shipping_address'] ?? '') ?></textarea>
                            <small class="form-text text-muted">Alamat detail tanpa nama kota/provinsi</small>
                        </div>

                        <h4>Informasi Pengiriman</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <select id="province" class="form-select">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota / Kabupaten</label>
                                <select id="city" name="shipping_city" class="form-select" disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="district" class="form-label">Kecamatan (District)</label>
                                <select id="district" name="district_id" class="form-select" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Kurir</label>
                                <select id="courier" class="form-select">
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Layanan</label>
                                <select id="service" class="form-select"></select>
                            </div>
                        </div>

                        <input type="hidden" name="shipping_courier" id="shipping_courier">
                        <input type="hidden" name="shipping_cost" id="shipping_cost">

                        <div class="mt-3">
                            <strong>Total Ongkir:</strong> <span id="ongkir_total">Rp0</span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="cod" id="pm1"
                                        class="form-check-input" checked>
                                    <label class="form-check-label" for="pm1">
                                        <i class="fas fa-truck me-2"></i> Bayar di Tempat (COD)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="transfer" id="pm2"
                                        class="form-check-input">
                                    <label class="form-check-label" for="pm2">
                                        <i class="fas fa-university me-2"></i> Transfer Bank (BCA, BNI, Mandiri)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="payment_method" value="ewallet" id="pm3"
                                        class="form-check-input">
                                    <label class="form-check-label" for="pm3">
                                        <i class="fas fa-wallet me-2"></i> E-Wallet (GoPay, OVO, DANA)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-checkout" id="checkout-btn">
                            <i class="fas fa-check-circle me-2"></i>
                            Bayar & Kirim Kejutan — <span id="btn-total">Rp
                                <?= number_format($productTotal, 0, ',', '.') ?></span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-md-5">
                <div class="summary-card">
                    <h5 class="summary-title">Ringkasan Pesanan</h5>
                    <ul class="list-group">
                        <?php foreach ($cart as $it):
                            $price = $it['price'];
                            $discount = $it['discount'] ?? 0;
                            $finalPrice = $discount > 0 ? ($price - ($price * $discount / 100)) : $price;
                            ?>
                            <li class="list-group-item">
                                <div>
                                    <div class="item-name"><?= htmlspecialchars($it['name']) ?></div>
                                    <small class="text-muted">Qty: <?= $it['qty'] ?></small>
                                    <?php if (!empty($it['custom_text'])): ?>
                                        <div class="item-detail">Teks: "<?= htmlspecialchars($it['custom_text']) ?>"</div>
                                    <?php endif; ?>
                                </div>
                                <div class="fw-bold">Rp <?= number_format($finalPrice * $it['qty'], 0, ',', '.') ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="total-row d-flex justify-content-between">
                        <span>Total Pembayaran</span>
                        <span id="summary-total">Rp <?= number_format($productTotal, 0, ',', '.') ?></span>
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
            const courierSelect = document.querySelector("#courier");
            const serviceSelect = document.querySelector("#service");
            const ongkirTotalEl = document.querySelector("#ongkir_total");
            const btnTotalEl = document.querySelector("#btn-total");
            const summaryTotalEl = document.querySelector("#summary-total");
            const productTotal = parseInt(document.getElementById('product_total').value);
            const form = document.getElementById('checkout-form');

            // Hidden inputs for location names
            const provinceNameInput = document.getElementById('province_name');
            const cityNameInput = document.getElementById('city_name');
            const districtNameInput = document.getElementById('district_name');

            // Reset select
            function resetSelect(selectElement, placeholderText, disable = true) {
                selectElement.innerHTML = `<option value="">${placeholderText}</option>`;
                selectElement.disabled = disable;
                if (selectElement === serviceSelect) {
                    ongkirTotalEl.innerText = "Rp0";
                    updateFinalTotal(0);
                }
            }

            resetSelect(citySelect, "Pilih Kota/Kabupaten");
            resetSelect(serviceSelect, "Pilih Layanan");

            // Load provinces
            provinceSelect.innerHTML = `<option value="">Memuat Provinsi...</option>`;
            fetch("?page=shipping_provinces")
                .then(res => res.json())
                .then(res => {
                    provinceSelect.innerHTML = "<option value=''>Pilih Provinsi</option>";
                    if (res.data?.length) {
                        res.data.forEach(p => {
                            provinceSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
                        });
                    }
                })
                .catch(err => {
                    console.error("Error loading provinces:", err);
                    provinceSelect.innerHTML = `<option value="">(Error)</option>`;
                    provinceSelect.disabled = true;
                });

            // Load cities & update province name
            provinceSelect.addEventListener("change", function () {
                const prov = this.value;
                resetSelect(citySelect, "Memuat Kota...");
                resetSelect(serviceSelect, "Pilih Layanan");

                // Simpan nama provinsi
                provinceNameInput.value = prov ? this.options[this.selectedIndex].text : '';

                if (!prov) {
                    resetSelect(citySelect, "Pilih Kota/Kabupaten");
                    cityNameInput.value = '';
                    districtNameInput.value = '';
                    return;
                }

                fetch(`?page=shipping_cities&province_id=${prov}`)
                    .then(res => res.json())
                    .then(res => {
                        citySelect.innerHTML = "<option value=''>Pilih Kota/Kabupaten</option>";
                        if (res.data?.length) {
                            res.data.forEach(c => {
                                citySelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                            });
                            citySelect.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error("Error loading cities:", err);
                        resetSelect(citySelect, "Error");
                    });
            });

            // Load districts & update city name
            citySelect.addEventListener("change", function () {
                const city = this.value;
                resetSelect(districtSelect, "Memuat Kecamatan...");
                resetSelect(serviceSelect, "Pilih Layanan");

                // Simpan nama kota
                cityNameInput.value = city ? this.options[this.selectedIndex].text : '';

                if (!city) {
                    resetSelect(districtSelect, "Pilih Kecamatan");
                    districtNameInput.value = '';
                    return;
                }

                fetch(`?page=shipping_districts&city_id=${city}`)
                    .then(res => res.json())
                    .then(res => {
                        districtSelect.innerHTML = "<option value=''>Pilih Kecamatan</option>";
                        if (res.data?.length) {
                            res.data.forEach(d => {
                                districtSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                            });
                            districtSelect.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error("Error loading districts:", err);
                        resetSelect(districtSelect, "Error");
                    });
            });

            // Update district name
            districtSelect.addEventListener("change", function () {
                districtNameInput.value = this.value ? this.options[this.selectedIndex].text : '';
            });

            // Calculate shipping cost
            function calculateCost() {
                const destination = districtSelect.value;
                const courier = courierSelect.value;

                resetSelect(serviceSelect, "Memuat Biaya...");
                updateFinalTotal(0);

                if (!destination || !courier) {
                    resetSelect(serviceSelect, "Pilih Kurir & Kota");
                    return;
                }

                const weight = 1;
                const form = new FormData();
                form.append("destination", destination);
                form.append("weight", weight);
                form.append("courier", courier);

                fetch("?page=shipping_cost", {
                    method: "POST",
                    body: form
                })
                    .then(res => res.json())
                    .then(res => {
                        serviceSelect.innerHTML = "";
                        let found = false;

                        if (Array.isArray(res.data)) {
                            res.data.forEach(item => {
                                if (item.service && item.cost !== undefined) {
                                    found = true;
                                    const cost = item.cost;
                                    const etd = item.etd || "?";
                                    serviceSelect.innerHTML += `
                                        <option value="${cost}" data-service="${item.service}">
                                            ${item.service} - Rp${new Intl.NumberFormat('id-ID').format(cost)} (${etd} hari)
                                        </option>
                                    `;
                                }
                            });
                        }

                        if (found) {
                            serviceSelect.disabled = false;
                            serviceSelect.dispatchEvent(new Event('change'));
                        } else {
                            resetSelect(serviceSelect, "Tidak Tersedia");
                        }
                    })
                    .catch(err => {
                        console.error("Error calculating cost:", err);
                        resetSelect(serviceSelect, "Error");
                    });
            }

            courierSelect.addEventListener("change", calculateCost);
            citySelect.addEventListener("change", calculateCost);
            districtSelect.addEventListener("change", calculateCost);

            // Update ongkir & total
            serviceSelect.addEventListener("change", function () {
                const cost = this.value ? parseInt(this.value) : 0;
                const service = this.selectedOptions[0]?.dataset.service || '';

                document.querySelector("#shipping_courier").value = cost ? (courierSelect.value.toUpperCase() + " - " + service) : "";
                document.querySelector("#shipping_cost").value = cost;
                ongkirTotalEl.innerText = "Rp" + new Intl.NumberFormat('id-ID').format(cost);
                updateFinalTotal(cost);
            });

            // Fungsi update total akhir
            function updateFinalTotal(shippingCost) {
                const final = productTotal + shippingCost;
                btnTotalEl.textContent = "Rp" + new Intl.NumberFormat('id-ID').format(final);
                summaryTotalEl.textContent = "Rp" + new Intl.NumberFormat('id-ID').format(final);
            }

            // Validasi sebelum submit
            form.addEventListener('submit', function (e) {
                const shippingCost = document.getElementById('shipping_cost').value;
                if (!shippingCost || parseInt(shippingCost) <= 0) {
                    alert('Silakan pilih layanan pengiriman terlebih dahulu.');
                    e.preventDefault();
                    return false;
                }

                // Validasi alamat lengkap
                if (!districtSelect.value || !citySelect.value || !provinceSelect.value) {
                    alert('Silakan lengkapi alamat pengiriman (Provinsi, Kota, Kecamatan).');
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
</body>

</html>