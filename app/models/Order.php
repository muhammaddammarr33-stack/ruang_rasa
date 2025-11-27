<?php
require_once __DIR__ . '/DB.php';

class Order
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function create($data, $cart)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, total_amount, payment_method, payment_status, order_status, shipping_address, created_at)
                VALUES (?, ?, ?, 'pending', 'waiting', ?, NOW())
            ");
            $stmt->execute([
                $data['user_id'],
                $data['total_amount'],
                $data['payment_method'],
                $data['shipping_address']
            ]);
            $orderId = $this->db->lastInsertId();

            // insert order_items
            $stmtItem = $this->db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
                VALUES (?, ?, ?, ?, ?)
            ");
            foreach ($cart as $item) {
                $finalPrice = isset($item['discount'])
                    ? $item['price'] - ($item['price'] * $item['discount'] / 100)
                    : $item['price'];

                $subtotal = $finalPrice * $item['qty'];
                $stmtItem->execute([$orderId, $item['id'], $item['qty'], $finalPrice, $subtotal]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAllByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetail($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT o.*, p.status AS payment_status_real, s.status AS shipping_status
            FROM orders o
            LEFT JOIN payments p ON o.id = p.order_id
            LEFT JOIN shippings s ON o.id = s.order_id
            WHERE o.id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $sql = "SELECT o.*, u.name AS user_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getShipping($orderId)
    {
        $sql = "SELECT * FROM shippings WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInvoiceData($orderId)
    {
        $stmt = $this->db->prepare("
        SELECT o.*, u.name AS customer_name, u.email AS customer_email
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        WHERE o.id = ?
    ");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $itemStmt = $this->db->prepare("
        SELECT oi.*, p.name AS product_name
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
        $itemStmt->execute([$orderId]);
        $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'order' => $order,
            'items' => $items
        ];
    }
    // app/models/Order.php
// tambahkan ke class Order

    public function revenueBetween($startDate, $endDate)
    {
        $stmt = $this->db->prepare("
        SELECT COALESCE(SUM(total_amount),0) AS total
        FROM orders
        WHERE payment_status = 'paid' AND DATE(created_at) BETWEEN ? AND ?
    ");
        $stmt->execute([$startDate, $endDate]);
        return (float) ($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }

    public function ordersBetween($startDate, $endDate)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS cnt
        FROM orders
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
        $stmt->execute([$startDate, $endDate]);
        return (int) ($stmt->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0);
    }

    public function avgOrderValueBetween($startDate, $endDate)
    {
        $orders = $this->ordersBetween($startDate, $endDate);
        if ($orders === 0)
            return 0;
        $rev = $this->revenueBetween($startDate, $endDate);
        return $rev / $orders;
    }

    public function itemsSoldBetween($startDate, $endDate)
    {
        $stmt = $this->db->prepare("
        SELECT COALESCE(SUM(oi.quantity),0) AS total_qty
        FROM order_items oi
        JOIN orders o ON o.id = oi.order_id
        WHERE DATE(o.created_at) BETWEEN ? AND ?
    ");
        $stmt->execute([$startDate, $endDate]);
        return (int) ($stmt->fetch(PDO::FETCH_ASSOC)['total_qty'] ?? 0);
    }

    public function newCustomersBetween($startDate, $endDate)
    {
        // if you store users.created_at
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS cnt
        FROM users
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
        $stmt->execute([$startDate, $endDate]);
        return (int) ($stmt->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0);
    }

    // trend per day between range (returns array of dates => [revenue, orders])
    public function dailyTrend($startDate, $endDate)
    {
        $stmt = $this->db->prepare("
        SELECT DATE(created_at) AS dt,
               COALESCE(SUM(total_amount),0) AS revenue,
               COUNT(*) AS orders
        FROM orders
        WHERE payment_status = 'paid' AND DATE(created_at) BETWEEN ? AND ?
        GROUP BY DATE(created_at)
        ORDER BY DATE(created_at) ASC
    ");
        $stmt->execute([$startDate, $endDate]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // build full date series
        $p1 = new DatePeriod(new DateTime($startDate), new DateInterval('P1D'), (new DateTime($endDate))->modify('+1 day'));
        $series = [];
        foreach ($p1 as $d) {
            $k = $d->format('Y-m-d');
            $series[$k] = ['revenue' => 0, 'orders' => 0];
        }
        foreach ($rows as $r) {
            $series[$r['dt']] = ['revenue' => (float) $r['revenue'], 'orders' => (int) $r['orders']];
        }
        return $series; // associative date => metrics
    }

    public function topProductsBetween($startDate, $endDate, $limit = 10)
    {
        $limit = (int) $limit;
        $sql = "
        SELECT p.id, p.name,
               SUM(oi.quantity) AS qty_sold,
               SUM(oi.subtotal) AS revenue
        FROM order_items oi
        JOIN orders o ON o.id = oi.order_id
        JOIN products p ON p.id = oi.product_id
        WHERE DATE(o.created_at) BETWEEN ? AND ?
        GROUP BY p.id
        ORDER BY qty_sold DESC
        LIMIT $limit
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function topCategoriesBetween($startDate, $endDate, $limit = 6)
    {
        $limit = (int) $limit;
        $sql = "
        SELECT c.id, c.name AS category,
               SUM(oi.quantity) AS qty_sold
        FROM order_items oi
        JOIN orders o ON o.id = oi.order_id
        JOIN products p ON p.id = oi.product_id
        JOIN categories c ON c.id = p.category_id
        WHERE DATE(o.created_at) BETWEEN ? AND ?
        GROUP BY c.id
        ORDER BY qty_sold DESC
        LIMIT $limit
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recentOrders($limit = 10)
    {
        $limit = (int) $limit;
        $sql = "
        SELECT o.*, u.name AS user_name
        FROM orders o
        LEFT JOIN users u ON u.id = o.user_id
        ORDER BY o.created_at DESC
        LIMIT $limit
    ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // FILTERED LIST with pagination
    // $filters = ['q'=>..., 'status'=>..., 'payment_status'=>..., 'date_from'=>..., 'date_to'=>...]
    public function filterList(array $filters = [], $page = 1, $perPage = 20)
    {
        $where = " WHERE 1=1 ";
        $params = [];

        if (!empty($filters['q'])) {
            $where .= " AND (o.id = ? OR u.name LIKE ? OR o.tracking_number LIKE ?)";
            $params[] = $filters['q'];
            $params[] = "%" . $filters['q'] . "%";
            $params[] = "%" . $filters['q'] . "%";
        }
        if (!empty($filters['status'])) {
            $where .= " AND o.order_status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['payment_status'])) {
            $where .= " AND o.payment_status = ?";
            $params[] = $filters['payment_status'];
        }
        if (!empty($filters['date_from'])) {
            $where .= " AND DATE(o.created_at) >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $where .= " AND DATE(o.created_at) <= ?";
            $params[] = $filters['date_to'];
        }

        // count total
        $countSql = "SELECT COUNT(*) as cnt FROM orders o LEFT JOIN users u ON u.id = o.user_id $where";
        $stmt = $this->db->prepare($countSql);
        $stmt->execute($params);
        $total = (int) ($stmt->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0);

        $offset = ($page - 1) * $perPage;
        $sql = "
            SELECT o.*, u.name as user_name
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            $where
            ORDER BY o.created_at DESC
            LIMIT $perPage OFFSET $offset
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['data' => $rows, 'total' => $total, 'page' => $page, 'per_page' => $perPage];
    }

    // get single order
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT o.*, u.name AS user_name, u.email AS user_email FROM orders o LEFT JOIN users u ON u.id = o.user_id WHERE o.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // get items with product info
    public function getItems($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name AS product_name, pi.image_path AS product_image
            FROM order_items oi
            LEFT JOIN products p ON p.id = oi.product_id
            LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // update order statuses (payment && order) - separate methods
    public function updatePaymentStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET payment_status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }
    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET order_status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }
    // helper for admin: return all payments for order
    public function getPayment($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE order_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancel($orderId, $reason = null)
    {
        // hanya bisa cancel jika status masih waiting atau processing
        $stmt = $this->db->prepare("
        UPDATE orders 
        SET order_status = 'cancelled', cancel_reason = ?, updated_at = NOW()
        WHERE id = ? AND order_status IN ('waiting', 'processing')
    ");
        return $stmt->execute([$reason, $orderId]);
    }

    public function refund($orderId, $amount, $note = null)
    {
        $stmt = $this->db->prepare("
        UPDATE orders 
        SET payment_status = 'refunded', refund_amount = ?, updated_at = NOW()
        WHERE id = ?
    ");
        return $stmt->execute([$amount, $orderId]);
    }


    public function addLog($orderId, $status)
    {
        $sql = "INSERT INTO order_logs (order_id, status, created_at)
            VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$orderId, $status]);
    }

    public function getLogs($orderId)
    {
        $sql = "SELECT * FROM order_logs WHERE order_id = ? ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTotal($orderId, $newTotal)
    {
        $stmt = $this->db->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
        return $stmt->execute([$newTotal, $orderId]);
    }

    public function getRecentUsers($limit = 5)
    {
        $stmt = $this->db->prepare("SELECT id, name, created_at FROM users ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
