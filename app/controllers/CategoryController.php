<?php
// app/controllers/CategoryController.php
require_once __DIR__ . '/../models/Category.php';
class CategoryController
{
    private $cat;
    public function __construct()
    {
        $this->cat = new Category();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $categories = $this->cat->all();
        include __DIR__ . '/../views/admin/categories/index.php';
    }

    public function form()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $cat = null;
        if (isset($_GET['id']))
            $cat = $this->cat->find((int) $_GET['id']);
        include __DIR__ . '/../views/admin/categories/form.php';
    }

    public function store()
    {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description'] ?? '');
        $this->cat->create($name, $desc);
        $_SESSION['success'] = "Kategori dibuat.";
        header("Location: ?page=admin_categories");
    }

    public function update()
    {
        $id = (int) $_POST['id'];
        $name = trim($_POST['name']);
        $desc = trim($_POST['description'] ?? '');
        $this->cat->update($id, $name, $desc);
        $_SESSION['success'] = "Kategori diupdate.";
        header("Location: ?page=admin_categories");
    }

    public function destroy()
    {
        $id = (int) $_GET['id'];
        $this->cat->delete($id);
        $_SESSION['success'] = "Kategori dihapus.";
        header("Location: ?page=admin_categories");
    }
}
