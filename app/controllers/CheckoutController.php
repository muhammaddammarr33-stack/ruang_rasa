<?php
// app/controllers/CheckoutController.php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Shipping.php';
require_once __DIR__ . '/../models/CustomOrder.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Memberships.php';

class CheckoutController
{
    public function form()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Silakan login dulu.";
            header("Location: ?page=login");
            exit;
        }
        $cart = $_SESSION['cart'] ?? [];
        include __DIR__ . '/../views/checkout/form.php';
    }

    public function process()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Silakan login dulu.";
            header("Location: ?page=login");
            exit;
        }

        $user = $_SESSION['user'];
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = "Keranjang kosong.";
            header("Location: ?page=cart");
            exit;
        }

        // Hitung total produk
        $total = 0;
        foreach ($cart as $it) {
            $price = $it['price'];
            $disc = isset($it['discount']) ? (float) $it['discount'] : 0;
            $finalPrice = $disc > 0 ? ($price - ($price * $disc / 100)) : $price;
            $total += $finalPrice * $it['qty'];
        }

        // Tambahkan ongkir
        $shippingCost = (int) ($_POST['shipping_cost'] ?? 0);
        if ($shippingCost < 0) {
            $_SESSION['error'] = "Biaya pengiriman tidak valid.";
            header("Location: ?page=checkout");
            exit;
        }
        $total += $shippingCost;

        // Gabungkan alamat lengkap
        $addressDetail = trim($_POST['shipping_address'] ?? '');
        $locationParts = array_filter([
            $_POST['district_name'] ?? '',
            $_POST['city_name'] ?? '',
            $_POST['province_name'] ?? ''
        ]);
        $fullAddress = $addressDetail;
        if (!empty($locationParts)) {
            $fullAddress .= ', ' . implode(', ', $locationParts);
        }

        $data = [
            'user_id' => $user['id'],
            'total_amount' => $total,
            'payment_method' => $_POST['payment_method'] ?? 'cod',
            'shipping_address' => $fullAddress
        ];

        $orderModel = new Order();
        $paymentModel = new Payment();
        $shippingModel = new Shipping();
        $productModel = new Product();
        $customModel = new CustomOrder();
        $membership = new Memberships();

        try {
            $orderId = $orderModel->create($data, $cart);

            // Buat record pembayaran (pending)
            $paymentModel->create($orderId, "midtrans", null, $total, "pending");

            // Simpan data pengiriman
            $shippingModel->createShipping(
                $orderId,
                $_POST['shipping_courier'],
                $shippingCost
            );

            // Proses custom order & stok
            foreach ($cart as $it) {
                if (!empty($it['custom_id'])) {
                    $customModel->linkToOrder($it['custom_id'], $orderId);
                }
                if (!empty($it['id'])) {
                    $productModel->reduceStock($it['id'], $it['qty']);
                }
            }

            // Pastikan membership ada
            $membership->ensureMembership($_SESSION['user']['id']);

            // Redeem poin (jika ada)
            $redeem = (int) ($_POST['redeem_points'] ?? 0);
            if ($redeem > 0) {
                $membershipData = $membership->get($_SESSION['user']['id']);
                if ($redeem <= $membershipData['points']) {
                    $discount = $redeem * 1000; // 1 poin = Rp 1.000
                    $newTotal = $total - $discount;
                    if ($newTotal < 0)
                        $newTotal = 0;

                    // Update total di order & payment
                    $orderModel->updateTotal($orderId, $newTotal);
                    $paymentModel->updateAmount($orderId, $newTotal);

                    $membership->deductPoints($_SESSION['user']['id'], $redeem);
                    $_SESSION['success'] = "Berhasil redeem $redeem poin (Rp " . number_format($discount) . ")";
                    $total = $newTotal; // update untuk log
                }
            }

            // Kosongkan cart
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Pesanan berhasil dibuat. ID: $orderId";
            header("Location: ?page=checkout_success&id=" . $orderId);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Gagal membuat pesanan: " . $e->getMessage();
            header("Location: ?page=checkout");
            exit;
        }
    }

    public function success()
    {
        include __DIR__ . '/../views/checkout/success.php';
    }
}