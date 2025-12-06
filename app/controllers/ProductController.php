<?php
// app/controllers/ProductController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Promotions.php'; // optional (kalau kamu mau badge promo)

class ProductController
{
    private $product;
    private $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();

        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    /* =========================
       🧩 ADMIN AREA
    ========================== */

    // 🟢 List semua produk di admin
    public function adminIndex()
    {
        $this->authorizeAdmin();
        $products = $this->product->all();
        include __DIR__ . '/../views/admin/products/index.php';
    }

    // 🟢 Form tambah / edit produk
    public function form()
    {
        $this->authorizeAdmin();
        $categories = $this->category->all();
        $product = null;
        $images = [];

        if (isset($_GET['id'])) {
            $product = $this->product->find((int) $_GET['id']);
            $images = $this->product->getImages((int) $_GET['id']);
        }

        include __DIR__ . '/../views/admin/products/form.php';
    }

    // 🟢 Simpan produk baru
    public function store()
    {
        $this->authorizeAdmin();
        try {
            $name = trim($_POST['name']);
            $description = trim($_POST['description'] ?? '');
            $price = (float) $_POST['price'];
            $stock = (int) ($_POST['stock'] ?? 0);
            $category_id = $_POST['category_id'] ?: null;

            $id = $this->product->create([
                'category_id' => $category_id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'discount' => 0,
                'stock' => $stock,
                'featured' => 0
            ]);

            /* 🔹 Upload gambar utama */
            if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = $this->handleUpload($_FILES['image']);
                $this->product->addImage($id, $filename, 1); // is_main = 1
            }

            /* 🔹 Upload gambar galeri */
            if (!empty($_FILES['gallery'])) {
                foreach ($_FILES['gallery']['name'] as $k => $n) {
                    if ($_FILES['gallery']['error'][$k] !== UPLOAD_ERR_OK)
                        continue;
                    $tmpFile = [
                        'name' => $n,
                        'tmp_name' => $_FILES['gallery']['tmp_name'][$k],
                        'error' => $_FILES['gallery']['error'][$k]
                    ];
                    $filename = $this->handleUpload($tmpFile);
                    $this->product->addImage($id, $filename, 0);
                }
            }

            $_SESSION['success'] = "Produk berhasil ditambahkan.";
            header("Location: ?page=admin_products");
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: ?page=admin_product_form");
        }
    }

    // 🟢 Update produk
    public function update()
    {
        $this->authorizeAdmin();
        try {
            $id = (int) $_POST['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description'] ?? '');
            $price = (float) $_POST['price'];
            $stock = (int) ($_POST['stock'] ?? 0);
            $category_id = $_POST['category_id'] ?: null;

            $this->product->update($id, [
                'category_id' => $category_id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'discount' => 0,
                'stock' => $stock,
                'featured' => 0
            ]);

            // upload gambar utama (jika baru)
            if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = $this->handleUpload($_FILES['image']);
                $this->product->addImage($id, $filename, 1);
            }

            // upload galeri baru
            if (!empty($_FILES['gallery'])) {
                foreach ($_FILES['gallery']['name'] as $k => $n) {
                    if ($_FILES['gallery']['error'][$k] !== UPLOAD_ERR_OK)
                        continue;
                    $tmpFile = [
                        'name' => $n,
                        'tmp_name' => $_FILES['gallery']['tmp_name'][$k],
                        'error' => $_FILES['gallery']['error'][$k]
                    ];
                    $filename = $this->handleUpload($tmpFile);
                    $this->product->addImage($id, $filename, 0);
                }
            }

            $_SESSION['success'] = "Produk berhasil diupdate.";
            header("Location: ?page=admin_products");
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: ?page=admin_product_form&id=" . $_POST['id']);
        }
    }

    // 🟢 Hapus produk
    public function destroy()
    {
        $this->authorizeAdmin();
        $id = (int) $_GET['id'];
        $this->product->delete($id);
        $_SESSION['success'] = "Produk berhasil dihapus.";
        header("Location: ?page=admin_products");
    }

    // 🟢 Hapus gambar galeri
    public function deleteImage()
    {
        $this->authorizeAdmin();
        $imgId = (int) $_GET['img_id'];
        $productId = (int) $_GET['product_id'];

        // ambil filename untuk hapus file fisik
        $images = $this->product->getImages($productId);
        $fileToDelete = null;
        foreach ($images as $img) {
            if ($img['id'] == $imgId) {
                $fileToDelete = $img['image_path'];
                break;
            }
        }

        $this->product->deleteImage($imgId);
        if ($fileToDelete && file_exists(__DIR__ . '/../../public/uploads/' . $fileToDelete)) {
            @unlink(__DIR__ . '/../../public/uploads/' . $fileToDelete);
        }

        $_SESSION['success'] = "Gambar berhasil dihapus.";
        header("Location: ?page=admin_product_form&id=$productId");
    }

    /* =========================
       🏠 USER AREA
    ========================== */

    // 🟢 Landing Page (home)
    // app/controllers/ProductController.php
    public function landing()
    {
        $productModel = $this->product;
        $categoryModel = $this->category;
        require_once __DIR__ . '/../models/Promotions.php';
        $promoModel = new Promotions();
        // ambil parameter search dan kategori dari URL
        $keyword = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        // ambil semua kategori
        $categories = $categoryModel->all();
        // ambil produk sesuai filter
        $rawProducts = $productModel->filter($keyword, $category);
        $products = [];

        // Tambahkan logika final price ke setiap produk
        foreach ($rawProducts as $p) {
            $priceData = $productModel->getFinalPrice($p['id']);
            $p['final_price'] = $priceData['final_price'];
            $p['discount_percent'] = $priceData['discount_percent'];
            $p['base_price'] = $priceData['base_price'];
            $products[] = $p;
        }

        include __DIR__ . '/../views/landing/index.php';
    }


    // 🟢 Halaman semua produk (search + filter)
    public function list()
    {
        $keyword = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $categories = $this->category->all();

        // Ambil data mentah
        $rawProducts = $this->product->filter($keyword, $category);
        $products = [];

        // Tambahkan logika diskon final ke setiap produk
        foreach ($rawProducts as $p) {
            $priceData = $this->product->getFinalPrice($p['id']);
            $p['final_price'] = $priceData['final_price'];
            $p['discount_percent'] = $priceData['discount_percent'];
            $p['base_price'] = $priceData['base_price'];
            $products[] = $p;
        }
        // 🔥 Tambahkan hitung unread count di sini
        $unreadConsultations = 0;
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            // Hitung langsung di sini (tanpa buat instance controller)
            $db = DB::getInstance();
            $stmt = $db->prepare("
            SELECT c.id,
                   (SELECT COUNT(*) FROM consultation_messages m2
                    WHERE m2.consultation_id = c.id
                    AND m2.sender_id != ?
                    AND (m2.created_at > c.last_read_at OR c.last_read_at IS NULL)
                   ) as unread
            FROM consultations c
            WHERE c.user_id = ? AND c.status IN ('suggested', 'in_progress')
        ");
            $stmt->execute([$userId, $userId]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $r) {
                $unreadConsultations += (int) $r['unread'];
            }
        }

        include __DIR__ . '/../views/landing/products.php';
    }

    // 🟢 Detail produk
    public function show()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $p = $this->product->find($id);
        if (!$p) {
            echo "Produk tidak ditemukan.";
            return;
        }

        $priceData = $this->product->getFinalPrice($id);
        $p['final_price'] = $priceData['final_price'];
        $p['discount_percent'] = $priceData['discount_percent'];
        $p['base_price'] = $priceData['base_price'];

        $images = $this->product->getImages($id);
        include __DIR__ . '/../views/landing/detail.php';
    }

    /* =========================
       🔧 UTILITIES
    ========================== */

    private function handleUpload($file)
    {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed))
            throw new Exception("Format file tidak didukung.");

        $filename = time() . '_' . preg_replace('/[^a-z0-9\-_\.]/i', '_', $file['name']);
        $dest = __DIR__ . '/../../public/uploads/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest))
            throw new Exception("Gagal memindahkan file upload.");

        return $filename;
    }

    private function authorizeAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
    }
}
