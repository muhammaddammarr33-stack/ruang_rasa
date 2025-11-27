<?php
// app/controllers/AdminDashboardController.php
require_once __DIR__ . '/../models/Order.php';

class AdminDashboardController
{
    private $orderModel;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $this->orderModel = new Order();
    }

    // render dashboard page (initial load)
    public function index()
    {
        // default range: last 7 days
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime('-6 days'));

        // prepare data for initial render
        $metrics = $this->gatherMetrics($start, $end);
        $salesChart = $this->orderModel->dailyTrend($start, $end);
        $topProducts = $this->orderModel->topProductsBetween($start, $end, 6);
        $topCategories = $this->orderModel->topCategoriesBetween($start, $end, 6);
        $recentOrders = $this->orderModel->recentOrders(10);

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    // returns JSON for AJAX when changing range
    public function data()
    {
        $start = $_GET['start'] ?? null;
        $end = $_GET['end'] ?? null;
        if (!$start || !$end) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid range']);
            exit;
        }

        $metrics = $this->gatherMetrics($start, $end);
        $trend = $this->orderModel->dailyTrend($start, $end); // returns ['Y-m-d' => ['revenue'=>..., 'orders'=>...]]
        $topProducts = $this->orderModel->topProductsBetween($start, $end, 10);
        $topCategories = $this->orderModel->topCategoriesBetween($start, $end, 6);
        $recentOrders = $this->orderModel->recentOrders(10);

        // 🔥 Ekstrak ke dalam array terurut
        $labels = [];
        $revenueSeries = [];
        $ordersSeries = [];

        foreach ($trend as $date => $values) {
            $labels[] = $date;
            $revenueSeries[] = (float) ($values['revenue'] ?? 0);
            $ordersSeries[] = (int) ($values['orders'] ?? 0);
        }

        echo json_encode([
            'metrics' => $metrics,
            'labels' => $labels,
            'revenue' => $revenueSeries,     // ✅ array: [208000]
            'orders' => $ordersSeries,       // ✅ array: [1]
            'topProducts' => $topProducts,
            'topCategories' => $topCategories,
            'recentOrders' => $recentOrders
        ]);
        exit;
    }

    // small activity feed endpoint
    public function activity()
    {
        // recent orders (5) and new users (5) combined
        $rows = $this->orderModel->recentOrders(5);
        // simplified feed
        $feed = [];
        foreach ($rows as $r) {
            $feed[] = [
                'type' => 'order',
                'text' => "Order #{$r['id']} baru (Rp " . number_format($r['total_amount'], 0, ',', '.') . ")",
                'time' => $r['created_at']
            ];
        }
        // new users
        $users = $this->orderModel->getRecentUsers(5);
        foreach ($users as $u) {
            $feed[] = [
                'type' => 'user',
                'text' => "User baru: {$u['name']}",
                'time' => $u['created_at']
            ];
        }
        // sort by time desc
        usort($feed, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        echo json_encode(array_slice($feed, 0, 10));
        exit;
    }

    // helper to compute metrics + previous period comparison
    private function gatherMetrics($start, $end)
    {
        $startPrev = date('Y-m-d', strtotime($start . ' -' . ((strtotime($end) - strtotime($start)) / 86400 + 1) . ' days'));
        $endPrev = date('Y-m-d', strtotime($start . ' -1 day'));

        $rev = $this->orderModel->revenueBetween($start, $end);
        $orders = $this->orderModel->ordersBetween($start, $end);
        $aov = $this->orderModel->avgOrderValueBetween($start, $end);
        $items = $this->orderModel->itemsSoldBetween($start, $end);
        $newCustomers = $this->orderModel->newCustomersBetween($start, $end);

        $revPrev = $this->orderModel->revenueBetween($startPrev, $endPrev);
        $ordersPrev = $this->orderModel->ordersBetween($startPrev, $endPrev);
        $aovPrev = $this->orderModel->avgOrderValueBetween($startPrev, $endPrev);
        $itemsPrev = $this->orderModel->itemsSoldBetween($startPrev, $endPrev);
        $newCustomersPrev = $this->orderModel->newCustomersBetween($startPrev, $endPrev);

        return [
            'revenue' => $rev,
            'orders' => $orders,
            'aov' => $aov,
            'items' => $items,
            'new_customers' => $newCustomers,
            'compare' => [
                'revenue_prev' => $revPrev,
                'orders_prev' => $ordersPrev,
                'aov_prev' => $aovPrev,
                'items_prev' => $itemsPrev,
                'new_customers_prev' => $newCustomersPrev
            ]
        ];
    }
}
