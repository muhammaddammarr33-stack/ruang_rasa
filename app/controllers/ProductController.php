<?php
// app/controllers/ProductController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController
{
    private $productModel;
    private $categoryModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    public function landing()
    {
        $search = $_GET['q'] ?? null;
        $cat = $_GET['category'] ?? null;
        $products = $this->productModel->all($search, $cat);
        $categories = $this->categoryModel->all();
        include __DIR__ . '/../views/landing/index.php';
    }

    public function adminProducts()
    {
        $products = $this->productModel->all();
        include __DIR__ . '/../views/admin/products.php';
    }

    public function createForm()
    {
        $categories = $this->categoryModel->all();
        include __DIR__ . '/../views/admin/product_form.php';
    }

    public function create()
    {
        $data = [
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'discount' => $_POST['discount'] ?? 0,
            'stock' => $_POST['stock'] ?? 0,
            'featured' => isset($_POST['featured']) ? 1 : 0
        ];
        $id = $this->productModel->create($data);

        // upload file
        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            $allowed = ['image/jpeg', 'image/png'];
            if (in_array($file['type'], $allowed) && $file['size'] <= 2 * 1024 * 1024) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'product_' . time() . '.' . $ext;
                move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public/uploads/' . $filename);
                $this->productModel->saveImage($id, $filename, 1);
            }
        }
        header("Location: ?page=admin_products");
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id)
            $this->productModel->delete($id);
        header("Location: ?page=admin_products");
    }

    public function editForm()
    {
        $id = $_GET['id'] ?? null;
        $product = $this->productModel->find($id);
        $categories = $this->categoryModel->all();
        include __DIR__ . '/../views/admin/product_edit.php';
    }

    public function update()
    {
        $id = $_POST['id'];
        $data = [
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'discount' => $_POST['discount'],
            'stock' => $_POST['stock'],
            'featured' => isset($_POST['featured']) ? 1 : 0
        ];
        $this->productModel->update($id, $data);

        // upload file baru
        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            $allowed = ['image/jpeg', 'image/png'];
            if (in_array($file['type'], $allowed) && $file['size'] <= 2 * 1024 * 1024) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'product_' . time() . '.' . $ext;
                move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public/uploads/' . $filename);
                $this->productModel->saveImage($id, $filename, 1);
            }
        }
        $_SESSION['success'] = "Produk berhasil diupdate!";
        header("Location: ?page=admin_products");
    }

    public function reviewFormAfterPurchase()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        $productId = $_GET['product_id'] ?? null;
        if (!$productId) {
            header("Location: ?page=user_orders");
            exit;
        }

        require_once __DIR__ . '/../models/DB.php';
        $db = DB::getInstance();
        $product = $db->prepare("SELECT * FROM products WHERE id = ?");
        $product->execute([$productId]);
        $product = $product->fetch();

        include __DIR__ . '/../views/products/review_after_purchase.php';
    }

    public function addReviewAfterPurchase()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        require_once __DIR__ . '/../models/ProductReview.php';
        $reviewModel = new ProductReview();

        $productId = $_POST['product_id'];
        $userId = $_SESSION['user']['id'];
        $rating = $_POST['rating'];
        $review = $_POST['review'];

        // Cegah review ganda
        $db = DB::getInstance();
        $check = $db->prepare("SELECT COUNT(*) FROM product_reviews WHERE product_id = ? AND user_id = ?");
        $check->execute([$productId, $userId]);
        if ($check->fetchColumn() > 0) {
            $_SESSION['error'] = "Anda sudah memberikan ulasan untuk produk ini.";
            header("Location: ?page=user_orders");
            exit;
        }

        $reviewModel->create($productId, $userId, $rating, $review);
        $_SESSION['success'] = "Ulasan Anda berhasil disimpan!";
        header("Location: ?page=user_orders");
    }



}
