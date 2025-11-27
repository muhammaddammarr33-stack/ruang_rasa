<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --accent: #7093B3;
            --accent-hover: #5d7da0;
            --sidebar-bg: #444B4F;
            --sidebar-text: #ecf0f1;
            --muted: #6c757d;
            --card-bg: #fff;
            --border-color: #e9ecef;
        }

        body {
            font-family: 'Poppins', system-ui, Arial, sans-serif;
            background: #FFFFFF;
            overflow-x: hidden;
            font-size: 0.875rem;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            z-index: 1000;
            transition: all 0.3s ease;
            padding-top: 12px;
        }

        #sidebar.collapsed {
            width: 70px;
        }

        #sidebar .nav-link {
            color: #bdc3c7;
            padding: 10px 14px;
            font-size: 0.9rem;
            border-radius: 0;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #fff;
            background: var(--accent);
        }

        #sidebar .nav-icon {
            width: 22px;
            text-align: center;
            margin-right: 10px;
            font-size: 0.95rem;
        }

        #sidebar.collapsed .nav-text {
            display: none;
        }

        #main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            padding: 12px;
        }

        #main-content.sidebar-collapsed {
            margin-left: 70px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: none;
            padding: 12px;
            margin-bottom: 12px;
        }

        .kpi .value {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .small-muted {
            color: var(--muted);
            font-size: 0.8125rem;
        }

        .range-btn {
            padding: 4px 8px;
            font-size: 0.8125rem;
        }

        .range-btn.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .feed-item {
            border-left: 2px solid var(--accent);
            padding: 6px 10px;
            margin-bottom: 6px;
            background: #fafafa;
            border-radius: 0 3px 3px 0;
            font-size: 0.8125rem;
        }

        .chart-container {
            height: 170px;
            width: 100%;
        }

        .trend-chart-container {
            height: 180px;
        }

        h6 {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }

        #sidebarToggle {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 4px 8px;
            font-size: 0.9rem;
        }

        .date-range-group {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .date-range-group input[type="date"] {
            width: auto;
            padding: 4px 8px;
            font-size: 0.875rem;
        }

        .date-range-group button {
            padding: 4px 8px;
            font-size: 0.875rem;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <nav id="sidebar" class="d-flex flex-column">
        <div class="px-3 mb-2">
            <h6 class="text-white mb-0 nav-text">Ruang Rasa</h6>
        </div>
        <ul class="nav nav-pills flex-column px-2">
            <li class="nav-item">
                <a class="nav-link active" href="?page=admin_dashboard">
                    <i class="bi bi-house nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=admin_categories">
                    <i class="bi bi-grid nav-icon"></i>
                    <span class="nav-text">Kategori</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=admin_products">
                    <i class="bi bi-box nav-icon"></i>
                    <span class="nav-text">Produk</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=admin_orders">
                    <i class="bi bi-cart nav-icon"></i>
                    <span class="nav-text">Pesanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=admin_consultations">
                    <i class="bi bi-chat-dots nav-icon"></i>
                    <span class="nav-text">Konsultasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=admin_promotions">
                    <i class="bi bi-percent nav-icon"></i>
                    <span class="nav-text">Promosi</span>
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link" href="?page=logout">
                    <i class="bi bi-box-arrow-right nav-icon"></i>
                    <span class="nav-text">Keluar</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div id="main-content">
        <button id="sidebarToggle" class="btn btn-sm mb-2">
            <i class="bi bi-list"></i>
        </button>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0 fw-semibold">Dashboard — Ruang Rasa</h5>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-secondary btn-sm range-btn" data-range="today">Hari ini</button>
                    <button class="btn btn-outline-secondary btn-sm range-btn" data-range="yesterday">Kemarin</button>
                    <button class="btn btn-outline-secondary btn-sm range-btn active" data-range="7d">7 Hari</button>
                    <button class="btn btn-outline-secondary btn-sm range-btn" data-range="30d">30 Hari</button>
                </div>
                <div class="date-range-group">
                    <input type="date" id="startDate" class="form-control form-control-sm">
                    <span>-</span>
                    <input type="date" id="endDate" class="form-control form-control-sm">
                    <button id="applyRange" class="btn btn-sm btn-primary">Terapkan</button>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="compareToggle" style="height:16px;width:28px;">
                    <label class="form-check-label small-muted" for="compareToggle" style="font-size:0.8125rem;">Bandingkan</label>
                </div>
            </div>
        </div>

        <!-- KPI Cards DENGAN ID -->
        <div class="row g-2 mb-2">
            <div class="col-6 col-md-3">
                <div class="card kpi">
                    <div class="small-muted">Total Pendapatan</div>
                    <div class="value" id="kpiRevenue">Rp <?= number_format($metrics['revenue'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span id="kpiRevenuePrev">Rp <?= number_format($metrics['compare']['revenue_prev'] ?? 0, 0, ',', '.') ?></span></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card kpi">
                    <div class="small-muted">Pesanan</div>
                    <div class="value" id="kpiOrders"><?= number_format($metrics['orders'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span id="kpiOrdersPrev"><?= number_format($metrics['compare']['orders_prev'] ?? 0, 0, ',', '.') ?></span></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card kpi">
                    <div class="small-muted">AOV</div>
                    <div class="value" id="kpiAOV">Rp <?= number_format($metrics['aov'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span id="kpiAOVPrev">Rp <?= number_format($metrics['compare']['aov_prev'] ?? 0, 0, ',', '.') ?></span></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card kpi">
                    <div class="small-muted">Produk Terjual</div>
                    <div class="value" id="kpiItems"><?= number_format($metrics['items'], 0, ',', '.') ?></div>
                    <div class="small-muted">Prev: <span id="kpiItemsPrev"><?= number_format($metrics['compare']['items_prev'] ?? 0, 0, ',', '.') ?></span></div>
                </div>
            </div>
        </div>

        <div class="row g-2">
            <!-- LEFT -->
            <div class="col-lg-8">
                <div class="card">
                    <h6>Revenue & Orders (Trend)</h6>
                    <div class="chart-container trend-chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <h6>Top Products</h6>
                    <div class="chart-container">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <h6>Kategori Terlaris</h6>
                    <div class="chart-container">
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">
                <div class="card">
                    <h6>Pesanan Terbaru</h6>
                    <div style="max-height:250px; overflow-y:auto;">
                        <ul id="recentOrdersList" class="list-unstyled mb-0">
                            <?php if (!empty($recentOrders)):
                                foreach ($recentOrders as $o): ?>
                                            <li class="mb-2">
                                                <div><strong>#<?= $o['id'] ?></strong>
                                                    <?= htmlspecialchars($o['user_name'] ?? 'Guest') ?></div>
                                                <div class="small-muted">Rp <?= number_format($o['total_amount'], 0, ',', '.') ?> —
                                                    <?= $o['created_at'] ?>
                                                </div>
                                            </li>
                                    <?php endforeach; else: ?>
                                    <li class="text-muted small">Belum ada pesanan</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <h6>Activity Feed</h6>
                    <div id="activityFeed" style="max-height:200px; overflow-y:auto;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main-content');
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('sidebar-collapsed');
        });

        function formatRp(n) {
            if (isNaN(n)) return 'Rp 0';
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }
        function q(sel) { return document.querySelector(sel); }
        function qAll(sel) { return document.querySelectorAll(sel); }

        // Data awal dari PHP
        const labels = <?= json_encode(array_keys($salesChart)) ?>;
        const initialRevenue = <?= json_encode(array_map(fn($v) => (float) ($v['revenue'] ?? 0), $salesChart)) ?>;
        const initialOrders = <?= json_encode(array_map(fn($v) => (int) ($v['orders'] ?? 0), $salesChart)) ?>;
        const topProducts = <?= json_encode($topProducts) ?>;
        const topCategories = <?= json_encode($topCategories) ?>;

        // Simpan semua chart
        let trendChart = null;
        let topProductsChart = null;
        let topCategoriesChart = null;

        /* ---------- Render Chart Functions ---------- */
        function renderTrendChart(labels, revenue, orders) {
            const ctx = q('#trendChart');
            if (!ctx) return;

            if (trendChart) trendChart.destroy();

            const trendCtx = ctx.getContext('2d');
            trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Revenue',
                            data: revenue,
                            yAxisID: 'y',
                            borderColor: '#7093B3',
                            backgroundColor: 'rgba(112,147,179,0.15)',
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2
                        },
                        {
                            label: 'Orders',
                            data: orders,
                            yAxisID: 'y1',
                            type: 'bar',
                            backgroundColor: 'rgba(112,147,179,0.35)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { font: { size: 10 } } }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            ticks: { callback: v => formatRp(v) }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        function renderTopProducts(products) {
            const ctx = q('#topProductsChart');
            if (!ctx) return;

            if (topProductsChart) topProductsChart.destroy();

            if (!products || products.length === 0) {
                ctx.parentNode.innerHTML = '<div class="text-muted small">Tidak ada data</div>';
                return;
            }

            const names = products.map(p => 
                (p.name || '').length > 20 ? (p.name || '').substring(0, 20) + '…' : (p.name || '')
            );
            const qty = products.map(p => parseInt(p.qty_sold) || 0);

            const newCtx = ctx.getContext('2d');
            topProductsChart = new Chart(newCtx, {
                type: 'bar',
                data: {
                    labels: names,
                    datasets: [{ label: 'Jumlah Terjual', data: qty, backgroundColor: '#7093B3' }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { font: { size: 9 } } }
                    },
                    layout: { padding: { left: 0, right: 10 } }
                }
            });
        }

        function renderTopCategories(categories) {
            const ctx = q('#topCategoriesChart');
            if (!ctx) return;

            if (topCategoriesChart) topCategoriesChart.destroy();

            if (!categories || categories.length === 0) {
                ctx.parentNode.innerHTML = '<div class="text-muted small">Tidak ada data</div>';
                return;
            }

            const names = categories.map(c => 
                (c.category || '').length > 20 ? (c.category || '').substring(0, 20) + '…' : (c.category || '')
            );
            const qty = categories.map(c => parseInt(c.qty_sold) || 0);

            const newCtx = ctx.getContext('2d');
            topCategoriesChart = new Chart(newCtx, {
                type: 'bar',
                data: {
                    labels: names,
                    datasets: [{ label: 'Jumlah Terjual', data: qty, backgroundColor: '#7093B3' }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { font: { size: 9 } } }
                    },
                    layout: { padding: { left: 0, right: 10 } }
                }
            });
        }

        /* ---------- Render Awal ---------- */
        renderTrendChart(labels, initialRevenue, initialOrders);
        renderTopProducts(topProducts);
        renderTopCategories(topCategories);

        /* ---------- Date Range ---------- */
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
            b.addEventListener('click', () => {
                qAll('.range-btn').forEach(x => x.classList.remove('active'));
                b.classList.add('active');
                const p = parseRangePreset(b.dataset.range);
                q('#startDate').value = toYMD(p.start);
                q('#endDate').value = toYMD(p.end);
                fetchData();
            });
        });

        if (!q('#startDate').value) {
            const p = parseRangePreset('7d');
            q('#startDate').value = toYMD(p.start);
            q('#endDate').value = toYMD(p.end);
        }

        q('#applyRange').addEventListener('click', fetchData);

        /* ---------- Fetch Data AJAX ---------- */
        function fetchData() {
            const start = q('#startDate').value;
            const end = q('#endDate').value;
            const compare = q('#compareToggle').checked ? 1 : 0;

            fetch(`?page=admin_dashboard_data&start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}&compare=${compare}`)
                .then(r => r.json())
                .then(j => {
                    if (j.error) return alert(j.error);

                    // Update KPI
                    q('#kpiRevenue').textContent = formatRp(j.metrics.revenue);
                    q('#kpiOrders').textContent = (j.metrics.orders || 0).toLocaleString('id-ID');
                    q('#kpiAOV').textContent = formatRp(Math.round(j.metrics.aov || 0));
                    q('#kpiItems').textContent = (j.metrics.items || 0).toLocaleString('id-ID');
                    q('#kpiRevenuePrev').textContent = formatRp(j.metrics.compare.revenue_prev || 0);
                    q('#kpiOrdersPrev').textContent = (j.metrics.compare.orders_prev || 0).toLocaleString('id-ID');
                    q('#kpiAOVPrev').textContent = formatRp(Math.round(j.metrics.compare.aov_prev || 0));
                    q('#kpiItemsPrev').textContent = (j.metrics.compare.items_prev || 0).toLocaleString('id-ID');

                    // Update semua chart
                    renderTrendChart(j.labels || [], j.revenue || [], j.orders || []);
                    renderTopProducts(j.topProducts || []);
                    renderTopCategories(j.topCategories || []);

                    // Update pesanan terbaru
                    const roList = q('#recentOrdersList');
                    if (roList) {
                        roList.innerHTML = '';
                        if (Array.isArray(j.recentOrders) && j.recentOrders.length) {
                            j.recentOrders.forEach(o => {
                                roList.insertAdjacentHTML('beforeend',
                                    `<li class="mb-2"><div><strong>#${o.id}</strong> ${o.user_name || 'Guest'}</div>
                                    <div class="small-muted">${formatRp(o.total_amount)} — ${o.created_at}</div></li>`
                                );
                            });
                        } else {
                            roList.innerHTML = '<li class="text-muted small">Belum ada pesanan</li>';
                        }
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Gagal memuat data. Lihat Console (F12).');
                });
        }

        /* ---------- Activity Feed ---------- */
        function loadActivity() {
            fetch('?page=admin_activity')
                .then(r => r.json())
                .then(list => {
                    const el = q('#activityFeed');
                    if (el) {
                        el.innerHTML = '';
                        (list || []).forEach(item => {
                            el.insertAdjacentHTML('beforeend',
                                `<div class="feed-item"><div>${item.text}</div><div class="small-muted">${item.time}</div></div>`
                            );
                        });
                    }
                })
                .catch(err => console.error('Gagal memuat activity feed:', err));
        }
        setInterval(loadActivity, 10000);
        loadActivity();
    </script>
</body>

</html>