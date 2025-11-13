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

    // create product (NO image column in products table)
    public function create($data)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO products (category_id, name, description, price, discount, stock, featured, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $data['category_id'] ?? null,
                $data['name'],
                $data['description'] ?? '',
                $data['price'] ?? 0,
                $data['discount'] ?? 0,
                $data['stock'] ?? 0,
                $data['featured'] ?? 0
            ]);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $sql = "UPDATE products SET category_id=?, name=?, description=?, price=?, discount=?, stock=?, featured=?, created_at=created_at";
            $params = [
                $data['category_id'] ?? null,
                $data['name'],
                $data['description'] ?? '',
                $data['price'] ?? 0,
                $data['discount'] ?? 0,
                $data['stock'] ?? 0,
                $data['featured'] ?? 0
            ];
            $sql .= " , updated_at = NOW() WHERE id = ?";
            $params[] = $id;
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function all()
    {
        $stmt = $this->db->prepare("
        SELECT p.*, c.name AS category_name, pi.image_path AS image,
               COALESCE(
                   (SELECT MAX(pr.discount)
                    FROM promotions pr
                    JOIN product_promotions pp ON pr.id = pp.promotion_id
                    WHERE pp.product_id = p.id
                      AND CURDATE() BETWEEN pr.start_date AND pr.end_date
                   ), 0
               ) AS promo_discount
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
        ORDER BY p.created_at DESC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
        SELECT p.*, c.name AS category_name, pi.image_path AS image,
               COALESCE(
                   (SELECT MAX(pr.discount)
                    FROM promotions pr
                    JOIN product_promotions pp ON pr.id = pp.promotion_id
                    WHERE pp.product_id = p.id
                      AND CURDATE() BETWEEN pr.start_date AND pr.end_date
                   ), 0
               ) AS promo_discount
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
        WHERE p.id = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // filter by keyword & category
    public function filter($search = '', $category = '')
    {
        $sql = "
        SELECT p.*, c.name AS category_name, pi.image_path AS image,
               COALESCE(
                   (SELECT MAX(pr.discount)
                    FROM promotions pr
                    JOIN product_promotions pp ON pr.id = pp.promotion_id
                    WHERE pp.product_id = p.id
                      AND CURDATE() BETWEEN pr.start_date AND pr.end_date
                   ), 0
               ) AS promo_discount
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
        WHERE 1
    ";

        $params = [];
        if ($search) {
            $sql .= " AND p.name LIKE ?";
            $params[] = "%$search%";
        }
        if ($category) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // gallery functions (is_main supported)
    public function addImage($productId, $path, $isMain = 0)
    {
        // if adding a main image, clear previous is_main flags
        if ((int) $isMain === 1) {
            $this->db->prepare("UPDATE product_images SET is_main = 0 WHERE product_id = ?")->execute([$productId]);
        }
        $stmt = $this->db->prepare("INSERT INTO product_images (product_id, image_path, is_main, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$productId, $path, $isMain ? 1 : 0]);
    }

    public function getImages($productId)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_main DESC, created_at ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteImage($id)
    {
        // optionally, you may unlink the file on disk in controller after getting the filename
        $stmt = $this->db->prepare("DELETE FROM product_images WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
