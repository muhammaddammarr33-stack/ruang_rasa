<?php
date_default_timezone_set('Asia/Jakarta');
// public/index.php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/AuthVerifyController.php'; // ✅ tambah baris ini
require_once __DIR__ . '/../app/controllers/ProfileController.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/CategoryController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/ConsultationController.php';
require_once __DIR__ . '/../app/controllers/CustomOrderController.php';
require_once __DIR__ . '/../app/controllers/PromotionController.php';
require_once __DIR__ . '/../app/controllers/ShippingController.php';
require_once __DIR__ . '/../app/controllers/MembershipController.php';
require_once __DIR__ . '/../app/helpers/ChatHelper.php';
// require_once __DIR__ . '/../app/controllers/ReferralController.php';
// require_once __DIR__ . '/../app/controllers/NewsletterController.php';
session_start();
$page = $_GET['page'] ?? 'home';

// controllers
$auth = new AuthController();
$profile = new ProfileController();
$productCtrl = new ProductController();
$categoryCtrl = new CategoryController();
$cartCtrl = new CartController();
$consultationCtrl = new ConsultationController();
$customCtrl = new CustomOrderController();
$promoCtrl = new PromotionController();
// $memberCtrl = new MembershipController();
// $refCtrl = new ReferralController();
// $newsCtrl = new NewsletterController();

switch ($page) {
    case 'landing':
    case 'home':
        $productCtrl->landing();
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $auth->register();
        else
            $auth->showRegister();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $auth->login();
        else
            $auth->showLogin();
        break;

    case 'logout':
        $auth->logout();
        break;

    case 'auth_verify':
        $controller = new AuthVerifyController();
        $controller->verify();
        break;

    case 'auth_forgot':
    case 'forgot':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $auth->forgot();
        else
            $auth->showForgot();
        break;

    case 'auth_reset':
    case 'reset':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $auth->reset();
        else
            $auth->showReset();
        break;

    case 'profile':
        $profile->index();
        break;

    case 'profile_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $profile->update();
        break;

    // admin
    case 'admin_dashboard':
        require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
        $adminDashboardCtrl = new AdminDashboardController();
        $adminDashboardCtrl->index();
        break;

    case 'admin_dashboard_data':
        require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
        $adminDashboardCtrl = new AdminDashboardController();
        $adminDashboardCtrl->data(); // returns JSON for AJAX
        break;

    case 'admin_activity':
        require_once __DIR__ . '/../app/controllers/AdminDashboardController.php';
        $adminDashboardCtrl = new AdminDashboardController();
        $adminDashboardCtrl->activity(); // returns JSON recent activity
        break;

    // ...
    case 'admin_products':
        $productCtrl->adminIndex();
        break;
    case 'admin_product_form':
        $productCtrl->form();
        break;
    case 'admin_product_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $productCtrl->store();
        break;
    case 'admin_product_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $productCtrl->update();
        break;
    case 'admin_product_delete':
        $productCtrl->destroy();
        break;
    case 'admin_product_delete_image':
        $productCtrl->deleteImage();
        break;

    // user product views
    case 'products':
        $productCtrl->list();
        break;
    case 'product_detail':
        $productCtrl->show();
        break;

    // categories
    case 'admin_categories':
        $categoryCtrl->index();
        break;
    case 'admin_category_form':
        $categoryCtrl->form();
        break;
    case 'admin_category_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $categoryCtrl->store();
        break;
    case 'admin_category_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $categoryCtrl->update();
        break;
    case 'admin_category_delete':
        $categoryCtrl->destroy();
        break;

    // ==== PROMOSI (ADMIN) ====
    case 'admin_promotions':
        $promoCtrl->adminIndex();
        break;

    case 'admin_promo_form':
        $promoCtrl->adminForm();
        break;

    case 'admin_promo_save':
        $promoCtrl->adminSave();
        break;

    case 'admin_promo_delete':
        $promoCtrl->adminDelete();
        break;

    // ==== PROMOSI (USER) ====
    case 'promotions':
        $promoCtrl->listPublic();
        break;

    // Cart
    case 'cart':
        $cartCtrl->index();
        break;
    case 'add_to_cart':
        $cartCtrl->add();
        break;
    case 'remove_from_cart':
        $cartCtrl->remove();
        break;
    case 'cart_update':
        $cartCtrl->update(); // optional if you implement qty update
        break;

    // Checkout
    case 'checkout':
        require_once __DIR__ . '/../app/controllers/CheckoutController.php';
        $checkoutCtrl = new CheckoutController();
        $checkoutCtrl->form();
        break;
    case 'checkout_process':
        require_once __DIR__ . '/../app/controllers/CheckoutController.php';
        $checkoutCtrl = new CheckoutController();
        $checkoutCtrl->process();
        break;
    case 'checkout_success':
        require_once __DIR__ . '/../app/controllers/CheckoutController.php';
        $checkoutCtrl = new CheckoutController();
        $checkoutCtrl->success();
        break;
    /***********************
     * ADMIN ORDERS MODULE
     ***********************/

    // List orders (search + filter + pagination)
    case 'admin_orders':
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->index();
        break;

    // Detail order
    case 'admin_order_detail':
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->detail();
        break;

    // Update status (order_status/payment_status)
    case 'admin_order_update':
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->updateStatus();
        break;

    // Cancel order
    case 'admin_order_cancel':
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->cancel();
        break;

    // Cancel order
    case 'admin_order_refund':
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->refund();
        break;


    // Export orders (CSV / Excel)
    case 'admin_order_export':
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->export();
        break;

    // user orders
    case 'orders':
        require_once '../app/controllers/OrderController.php';
        $orderCtrl = new OrderController();
        $orderCtrl->history();
        break;

    case 'order_detail':
        require_once '../app/controllers/OrderController.php';
        $orderCtrl = new OrderController();
        $orderCtrl->detail();
        break;

    // ===================== ORDER CONTROLLER =====================

    case 'custom_form':
        require_once __DIR__ . '/../app/controllers/CustomOrderController.php';
        $customOrderCtrl = new CustomOrderController();
        $customOrderCtrl->form();
        break;

    case 'custom_create':
        require_once __DIR__ . '/../app/controllers/CustomOrderController.php';
        $customOrderCtrl = new CustomOrderController();
        $customOrderCtrl->create();
        break;

    case 'invoice':
        require_once '../app/controllers/InvoiceController.php';
        $invoiceCtrl = new InvoiceController();
        $invoiceCtrl->generate();
        break;

    case 'get_snap_token':
        require_once __DIR__ . '/../app/controllers/PaymentController.php';
        $paymentCtrl = new PaymentController();
        $paymentCtrl->getSnapToken();
        break;

    case 'payment_verify':
        require_once __DIR__ . '/../app/controllers/PaymentController.php';
        $paymentCtrl = new PaymentController();
        $paymentCtrl->verify();
        break;

    case 'save_transaction':
        require_once __DIR__ . '/../app/controllers/PaymentController.php';
        $paymentCtrl = new PaymentController();
        $paymentCtrl->saveTransaction();
        break;

    // ...

    case 'admin_update_order_status':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $adminOrderCtrl = new AdminOrderController();
        $adminOrderCtrl->updateStatus();
        break;


    case 'admin_payments':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/payments.php';
        break;

    // ...
    case 'user_dashboard':
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/user/dashboard.php';
        break;

    case 'user_orders':
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/user/orders.php';
        break;

    // API RajaOngkir
    case 'shipping_provinces':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->provinces();
        exit; // 👈 UBAH DARI break; MENJADI exit;
    // break; // Hapus atau jadikan komentar

    case 'shipping_cities':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->cities();
        exit; // 👈 UBAH DARI break; MENJADI exit;
    // break;

    case 'shipping_districts':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->districts();
        exit; // Wajib exit;

    case 'shipping_subdistricts':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->subdistricts();
        exit; // Wajib exit;

    case 'shipping_cost':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->cost();
        exit; // 👈 UBAH DARI break; MENJADI exit;
    // break;

    // Untuk kasus admin, jika tidak ada output JSON, biarkan break; jika ada output, gunakan exit;
    case 'admin_shipping_update_tracking':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->updateTracking();
        break; // Asumsi: fungsi ini tidak mengeluarkan JSON mentah

    case 'admin_shipping_update_status':
        require_once __DIR__ . '/../app/controllers/ShippingController.php';
        $shippingCtrl = new ShippingController();
        $shippingCtrl->updateStatus();
        break; // Asumsi: fungsi ini tidak mengeluarkan JSON mentah

    // Admin rewards
    case 'admin_rewards':
        require_once __DIR__ . '/../app/controllers/AdminRewardsController.php';
        $adminRewardsCtrl = new AdminRewardsController();
        $adminRewardsCtrl->index();
        break;
    case 'admin_rewards_form':
        require_once __DIR__ . '/../app/controllers/AdminRewardsController.php';
        $adminRewardsCtrl = new AdminRewardsController();
        $adminRewardsCtrl->form();
        break;
    case 'admin_rewards_store':
        require_once __DIR__ . '/../app/controllers/AdminRewardsController.php';
        $adminRewardsCtrl = new AdminRewardsController();
        $adminRewardsCtrl->store();
        break;
    case 'admin_rewards_update':
        require_once __DIR__ . '/../app/controllers/AdminRewardsController.php';
        $adminRewardsCtrl = new AdminRewardsController();
        $adminRewardsCtrl->update();
        break;
    case 'admin_rewards_delete':
        require_once __DIR__ . '/../app/controllers/AdminRewardsController.php';
        $adminRewardsCtrl = new AdminRewardsController();
        $adminRewardsCtrl->destroy();
        break;

    // User rewards
    case 'user_rewards':
        require_once __DIR__ . '/../app/controllers/RewardController.php';
        (new RewardController())->catalog();
        break;
    case 'claim_reward':
    case 'user_rewards_claim': // alias
        require_once __DIR__ . '/../app/controllers/RewardController.php';
        (new RewardController())->claim();
        break;

    // USER reward history
    case 'user_reward_history':
        require_once __DIR__ . '/../app/controllers/UserRewardHistoryController.php';
        $c = new UserRewardHistoryController();
        $c->index();
        break;

    // ADMIN reward redemptions
    case 'admin_reward_redemptions':
        require_once __DIR__ . '/../app/controllers/AdminRewardRedemptionController.php';
        $c = new AdminRewardRedemptionController();
        $c->index();
        break;


    /* ===============================
       CONSULTATION (USER SIDE)
   ================================ */
    case 'consultations':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->list();
        break;

    case 'consultation_form':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->form();
        break;

    case 'consultation_create':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->create();
        break;

    case 'consultation_feedback':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->feedbackForm();
        break;

    case 'consultation_feedback_submit':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->submitFeedback();
        break;

    case 'consultation_direct':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->startDirectChat();
        break;

    /* ===== ADMIN CONSULTATION FINAL ROUTES ===== */

    case 'admin_consultations':
        require_once __DIR__ . '/../app/controllers/AdminConsultationController.php';
        (new AdminConsultationController())->index();
        break;

    case 'admin_consultation_detail':
        require_once __DIR__ . '/../app/controllers/AdminConsultationController.php';
        (new AdminConsultationController())->detail();
        break;

    /* AI Suggestion */
    case 'admin_consultation_ai':
        require_once __DIR__ . '/../app/controllers/AdminConsultationController.php';
        (new AdminConsultationController())->aiSuggest();
        break;

    /* Manual suggest */
    case 'consultation_suggest':
        require_once __DIR__ . '/../app/controllers/AdminConsultationController.php';
        (new AdminConsultationController())->suggestForm();
        break;

    case 'consultation_suggest_save':
        require_once __DIR__ . '/../app/controllers/AdminConsultationController.php';
        (new AdminConsultationController())->saveSuggestion();
        break;


    /* Mark completed */
    case 'admin_consultation_done':
        require_once __DIR__ . '/../app/controllers/AdminConsultationController.php';
        (new AdminConsultationController())->markDone();
        break;

    // chat endpoints
    case 'consultation_chat':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->chatPage();
        break;

    case 'chat_send':
        require_once __DIR__ . '/../app/controllers/ConsultationChatController.php';
        (new ConsultationChatController())->sendMessage();
        break;

    case 'chat_fetch':
        require_once __DIR__ . '/../app/controllers/ConsultationChatController.php';
        (new ConsultationChatController())->fetchMessages();
        break;

    case 'add_to_cart_ajax':
        require_once __DIR__ . '/../app/controllers/CartController.php';
        echo (new CartController())->addToCartAjax();
        exit;

    case 'complete_consultation':
        require_once __DIR__ . '/../app/controllers/ConsultationController.php';
        (new ConsultationController())->completeConsultation();
        break;


    // case 'chat_send':
    //     require_once __DIR__ . '/../app/controllers/ChatController.php';
    //     (new ChatController())->send();
    //     break;
    // case 'chat_fetch':
    //     require_once __DIR__ . '/../app/controllers/ChatController.php';
    //     (new ChatController())->fetch();
    //     break;
    // case 'chat_mark_read':
    //     require_once __DIR__ . '/../app/controllers/ChatController.php';
    //     (new ChatController())->markRead();
    //     break;
    // case 'chat_unread_count':
    //     require_once __DIR__ . '/../app/controllers/ChatController.php';
    //     (new ChatController())->unreadCount();
    //     break;



    // case 'product_detail':
    //     include __DIR__ . '/../app/views/products/detail.php';
    //     break;

    // // Review setelah pembelian
    // case 'add_review_after_purchase':
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $productCtrl->addReviewAfterPurchase();
    //     } else {
    //         $productCtrl->reviewFormAfterPurchase();
    //     }
    //     break;

    // case 'custom_form':
    //     if (!isset($_SESSION['user'])) {
    //         header("Location: ?page=login");
    //         exit;
    //     }
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST')
    //         $customCtrl->create();
    //     else
    //         $customCtrl->form();
    //     break;

    // case 'custom_orders':
    //     if (!isset($_SESSION['user'])) {
    //         header("Location: ?page=login");
    //         exit;
    //     }
    //     $customCtrl->list();
    //     break;

    // case 'custom_detail':
    //     if (!isset($_SESSION['user'])) {
    //         header("Location: ?page=login");
    //         exit;
    //     }
    //     $customCtrl->detail();
    //     break;

    // case 'promotions':
    //     $promoCtrl->list();
    //     break;

    // case 'membership_dashboard':
    //     if (!isset($_SESSION['user'])) {
    //         header("Location: ?page=login");
    //         exit;
    //     }
    //     $memberCtrl->dashboard();
    //     break;

    // case 'membership_redeem':
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST')
    //         $memberCtrl->redeem();
    //     break;

    // case 'referral_submit':
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST')
    //         $refCtrl->submit();
    //     break;

    // case 'newsletter_subscribe':
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST')
    //         $newsCtrl->subscribe();
    //     break;


    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page not found";
        break;
}
