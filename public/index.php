<?php
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
// require_once __DIR__ . '/../app/controllers/MembershipController.php';
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
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/dashboard.php';
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


    // ...
    case 'add_to_cart':
        $cartCtrl->add();
        break;
    case 'cart':
        $cartCtrl->index();
        break;
    case 'remove_from_cart':
        $cartCtrl->remove();
        break;
    case 'checkout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $cartCtrl->checkout();
        else
            $cartCtrl->checkoutForm();
        break;

    case 'admin_orders':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/orders.php';
        break;

    case 'admin_update_order_status':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $ctrl = new AdminOrderController();
        $ctrl->updateStatus();
        break;

    case 'admin_order_reviews':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
        $ctrl = new AdminOrderController();
        $ctrl->showReviews();
        break;


    case 'admin_payments':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/payments.php';
        break;

    case 'admin_consultations':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/consultations.php';
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
    // konsultasi
    case 'consultation_form':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $consultationCtrl->create();
        else
            $consultationCtrl->form();
        break;

    case 'consultations':
        $consultationCtrl->list();
        break;

    case 'consultation_suggest':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $consultationCtrl->saveSuggestion();
        else
            $consultationCtrl->suggestForm();
        break;

    case 'consultation_feedback':
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $consultationCtrl->submitFeedback();
        else
            $consultationCtrl->feedbackForm();
        break;

    case 'admin_consultation':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/consultations.php';
        break;

    case 'admin_consultation_detail':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/consultation_detail.php';
        break;

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

    case 'custom_form':
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $customCtrl->create();
        else
            $customCtrl->form();
        break;

    case 'custom_orders':
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        $customCtrl->list();
        break;

    case 'custom_detail':
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }
        $customCtrl->detail();
        break;

    case 'admin_order_detail':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        include __DIR__ . '/../app/views/admin/order_detail.php';
        break;

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
