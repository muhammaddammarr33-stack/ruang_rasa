<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

// expected variables from controller:
// $metrics (array), $salesChart (assoc date=>metrics), $topProducts, $topCategories, $recentOrders

$metrics = $metrics ?? [
    'revenue' => 0,
    'orders' => 0,
    'aov' => 0,
    'items' => 0,
    'new_customers' => 0,
    'compare' => []
];
$salesChart = $salesChart ?? [];
$topProducts = $topProducts ?? [];
$topCategories = $topCategories ?? [];
$recentOrders = $recentOrders ?? [];
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard — Ruang Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --accent: #4B9CE2;
            --muted: #6c757d
        }

        body {
            font-family: Poppins, system-ui, Arial;
            background: #f6f8fb
        }

        .card-rounded {
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(20, 33, 61, 0.06)
        }

        .small-muted {
            color: var(--muted);
            font-size: .9rem
        }

        .kpi .value {
            font-weight: 700;
            font-size: 1.4rem
        }

        .range-btn.active {
            background: var(--accent);
            color: #fff
        }

        .feed-item {
            border-left: 3px solid rgba(75, 156, 226, 0.12);
            padding: 8px 12px;
            margin-bottom: 8px;
            background: #fff
        }
    </style>
</head>

<body>
    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Dashboard — Ruang Rasa</h3>
            <div>
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <button class="btn btn-outline-secondary btn-sm range-btn" data-range="today">Hari ini</button>
                        <button class="btn btn-outline-secondary btn-sm range-btn"
                            data-range="yesterday">Kemarin</button>
                        <button class="btn btn-outline-secondary btn-sm range-btn active" data-range="7d">7
                            Hari</button>
                        <button class="btn btn-outline-secondary btn-sm range-btn" data-range="30d">30 Hari</button>
                    </div>
                    <div class="me-2">
                        <input type="date" id="startDate"> - <input type="date" id="endDate">
                        <button id="applyRange" class="btn btn-sm btn-primary">Terapkan</button>
                    </div>
                    <div class="form-check form-switch ms-3">
                        <input class="form-check-input" type="checkbox" id="compareToggle">
                        <label class="form-check-label small-muted" for="compareToggle">Bandingkan periode
                            sebelumnya</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="p-3 bg-white card-rounded kpi">
                    <div class="small-muted">Total Pendapatan</div>
                    <div class="value" id="kpiRevenue">Rp <?= number_format($metrics['revenue'], 0, ',', '.') ?></div>
                    <div class="small-muted">Periode sebelumnya: <span
                            id="kpiRevenuePrev"><?= number_format($metrics['compare']['revenue_prev'] ?? 0, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-white card-rounded kpi">
                    <div class="small-muted">Pesanan</div>
                    <div class="value" id="kpiOrders"><?= number_format($metrics['orders'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span
                            id="kpiOrdersPrev"><?= number_format($metrics['compare']['orders_prev'] ?? 0, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-white card-rounded kpi">
                    <div class="small-muted">AOV</div>
                    <div class="value" id="kpiAOV">Rp <?= number_format($metrics['aov'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span
                            id="kpiAOVPrev"><?= number_format($metrics['compare']['aov_prev'] ?? 0, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-white card-rounded kpi">
                    <div class="small-muted">Produk Terjual</div>
                    <div class="value" id="kpiItems"><?= number_format($metrics['items'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span
                            id="kpiItemsPrev"><?= number_format($metrics['compare']['items_prev'] ?? 0, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- LEFT: Charts & Top products -->
            <div class="col-lg-8">

                <div class="bg-white p-3 card-rounded mb-3">
                    <h6>Revenue & Orders (Trend)</h6>
                    <canvas id="trendChart" height="120"></canvas>
                </div>

                <div class="bg-white p-3 card-rounded mb-3">
                    <h6>Top Products</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody id="topProductsBody">
                            <?php if (!empty($topProducts)):
                                foreach ($topProducts as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['name']) ?></td>
                                        <td><?= (int) $p['qty_sold'] ?></td>
                                        <td>Rp <?= number_format($p['revenue'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- RIGHT: categories, recent orders, activity -->
            <div class="col-lg-4">
                <div class="bg-white p-3 card-rounded mb-3">
                    <h6>Kategori Terlaris</h6>
                    <ul id="catList" class="list-unstyled mb-0">
                        <?php if (!empty($topCategories)):
                            foreach ($topCategories as $c): ?>
                                <li class="mb-2"><?= htmlspecialchars($c['category']) ?> — <?= (int) $c['qty_sold'] ?></li>
                            <?php endforeach; else: ?>
                            <li class="text-muted">Belum ada data</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="bg-white p-3 card-rounded mb-3">
                    <h6>Pesanan Terbaru</h6>
                    <div style="max-height:220px;overflow:auto">
                        <ul id="recentOrdersList" class="list-unstyled mb-0">
                            <?php if (!empty($recentOrders)):
                                foreach ($recentOrders as $o): ?>
                                    <li class="mb-2">
                                        <div><strong>#<?= $o['id'] ?></strong>
                                            <?= htmlspecialchars($o['user_name'] ?? 'Guest') ?></div>
                                        <div class="small-muted">Rp <?= number_format($o['total_amount'], 0, ',', '.') ?> —
                                            <?= $o['created_at'] ?></div>
                                    </li>
                                <?php endforeach; else: ?>
                                <li class="text-muted">Belum ada pesanan</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="bg-white p-3 card-rounded mb-3">
                    <h6>Activity Feed</h6>
                    <div id="activityFeed" style="max-height:220px;overflow:auto"></div>
                </div>
            </div>
        </div>

    </div>

    <script>
        /* ---------- helper ---------- */
        function formatRp(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }
        function q(sel) { return document.querySelector(sel); }
        function qAll(sel) { return document.querySelectorAll(sel); }

        /* ---------- initial data from PHP ---------- */
        let labels = <?= json_encode(array_keys($salesChart)) ?>;
        let initialRevenue = <?= json_encode(array_map(function ($v) {
            return $v['revenue']; }, $salesChart)) ?>;
        let initialOrders = <?= json_encode(array_map(function ($v) {
            return $v['orders']; }, $salesChart)) ?>;

        /* ---------- Chart setup (dual axis) ---------- */
        const ctx = document.getElementById('trendChart').getContext('2d');
        let trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { type: 'line', label: 'Revenue', data: initialRevenue, yAxisID: 'y', borderColor: '#4B9CE2', backgroundColor: 'rgba(75,156,226,0.15)', tension: 0.3 },
                    { type: 'bar', label: 'Orders', data: initialOrders, yAxisID: 'y1', backgroundColor: 'rgba(75,156,226,0.35)' }
                ]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, position: 'left', ticks: { callback: v => formatRp(v) } },
                    y1: { beginAtZero: true, position: 'right', grid: { display: false } }
                }
            }
        });

        /* ---------- Date range controls ---------- */
        function parseRangePreset(preset) {
            const today = new Date();
            let start, end;
            if (preset === 'today') { start = end = today; }
            else if (preset === 'yesterday') { let t = new Date(); t.setDate(t.getDate() - 1); start = end = t; }
            else if (preset === '7d') { let s = new Date(); s.setDate(s.getDate() - 6); start = s; end = today; }
            else if (preset === '30d') { let s = new Date(); s.setDate(s.getDate() - 29); start = s; end = today; }
            return { start, end };
        }
        function toYMD(d) { return d.toISOString().slice(0, 10); }

        qAll('.range-btn').forEach(b => {
            b.addEventListener('click', e => {
                qAll('.range-btn').forEach(x => x.classList.remove('active'));
                b.classList.add('active');
                const p = parseRangePreset(b.dataset.range);
                q('#startDate').value = toYMD(p.start);
                q('#endDate').value = toYMD(p.end);
                fetchData();
            });
        });

        // apply initial 7d
        if (!q('#startDate').value) { let p = parseRangePreset('7d'); q('#startDate').value = toYMD(p.start); q('#endDate').value = toYMD(p.end); }

        q('#applyRange').addEventListener('click', fetchData);

        /* ---------- fetchData (AJAX to admin_dashboard_data) ---------- */
        function fetchData() {
            const start = q('#startDate').value;
            const end = q('#endDate').value;
            const compare = q('#compareToggle').checked ? 1 : 0;

            fetch(`?page=admin_dashboard_data&start=${start}&end=${end}&compare=${compare}`)
                .then(r => r.json())
                .then(j => {
                    if (j.error) return alert(j.error);

                    // update KPI
                    q('#kpiRevenue').textContent = formatRp(j.metrics.revenue);
                    q('#kpiOrders').textContent = j.metrics.orders.toLocaleString();
                    q('#kpiAOV').textContent = formatRp(Math.round(j.metrics.aov));
                    q('#kpiItems').textContent = j.metrics.items.toLocaleString();

                    q('#kpiRevenuePrev').textContent = formatRp(j.metrics.compare.revenue_prev);
                    q('#kpiOrdersPrev').textContent = j.metrics.compare.orders_prev.toLocaleString();
                    q('#kpiAOVPrev').textContent = formatRp(Math.round(j.metrics.compare.aov_prev));
                    q('#kpiItemsPrev').textContent = j.metrics.compare.items_prev.toLocaleString();

                    // update charts
                    trendChart.data.labels = j.labels;
                    trendChart.data.datasets[0].data = j.revenue;
                    trendChart.data.datasets[1].data = j.orders;
                    trendChart.update();

                    // top products
                    const tpBody = q('#topProductsBody'); tpBody.innerHTML = '';
                    if (j.topProducts && j.topProducts.length) {
                        j.topProducts.forEach(p => {
                            tpBody.insertAdjacentHTML('beforeend', `<tr><td>${p.name}</td><td>${p.qty_sold}</td><td>${formatRp(p.revenue)}</td></tr>`);
                        });
                    } else {
                        tpBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>';
                    }

                    // categories
                    const catList = q('#catList'); catList.innerHTML = '';
                    if (j.topCategories && j.topCategories.length) {
                        j.topCategories.forEach(c => { catList.insertAdjacentHTML('beforeend', `<li class="mb-2">${c.category} — ${c.qty_sold}</li>`); });
                    } else catList.innerHTML = '<li class="text-muted">Belum ada data</li>';

                    // recent orders
                    const recentList = q('#recentOrdersList'); recentList.innerHTML = '';
                    if (j.recentOrders && j.recentOrders.length) {
                        j.recentOrders.forEach(o => {
                            recentList.insertAdjacentHTML('beforeend', `<li class="mb-2"><div><strong>#${o.id}</strong> ${o.user_name || 'Guest'}</div><div class="small-muted">${formatRp(o.total_amount)} — ${o.created_at}</div></li>`);
                        });
                    } else recentList.innerHTML = '<li class="text-muted">Belum ada pesanan</li>';
                })
                .catch(err => { console.error(err); alert('Gagal mengambil data'); });
        }

        /* ---------- Activity feed (poll every 10s) ---------- */
        function loadActivity() {
            fetch('?page=admin_activity')
                .then(r => r.json())
                .then(list => {
                    const el = q('#activityFeed'); el.innerHTML = '';
                    list.forEach(item => {
                        el.insertAdjacentHTML('beforeend', `<div class="feed-item"><div>${item.text}</div><div class="small-muted">${item.time}</div></div>`);
                    });
                });
        }
        setInterval(loadActivity, 10000);
        loadActivity();
    </script>

</body>

</html>