<?php
// app/models/Product.php
require_once __DIR__ . '/DB.php';

class Product
{
    private $db;
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function all($search = null, $category_id = null)
    {
        $sql = "SELECT p.*, pi.image_path FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
                WHERE 1=1";
        $params = [];
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        if ($category_id) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category_id;
        }
        $sql .= " ORDER BY p.featured DESC, p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO products (category_id, name, description, price, discount, stock, featured) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['discount'] ?? 0,
            $data['stock'] ?? 0,
            $data['featured'] ? 1 : 0
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, discount=?, stock=?, featured=? WHERE id=?");
        return $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['discount'],
            $data['stock'],
            $data['featured'],
            $id
        ]);
    }

    public function delete($id)
    {
        // hapus gambar juga
        $this->db->prepare("DELETE FROM product_images WHERE product_id = ?")->execute([$id]);
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function saveImage($product_id, $filename, $is_main = 1)
    {
        $stmt = $this->db->prepare("INSERT INTO product_images (product_id, image_path, is_main) VALUES (?, ?, ?)");
        return $stmt->execute([$product_id, $filename, $is_main]);
    }
}
