<?php
// app/controllers/CategoryController.php
require_once __DIR__ . '/../models/Category.php';
class CategoryController
{
    private $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new Category();
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    public function adminCategories()
    {
        $categories = $this->categoryModel->all();
        include __DIR__ . '/../views/admin/categories.php';
    }

    public function createForm()
    {
        include __DIR__ . '/../views/admin/category_form.php';
    }

    public function create()
    {
        $name = $_POST['name'];
        $slug = strtolower(str_replace(' ', '-', $name));
        $stmt = DB::getInstance()->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->execute([$name, $slug]);
        header("Location: ?page=admin_categories");
    }

    public function delete()
    {
        $id = $_GET['id'];
        DB::getInstance()->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
        header("Location: ?page=admin_categories");
    }

}
