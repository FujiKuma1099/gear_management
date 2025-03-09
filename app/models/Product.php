<?php

namespace App\Models;

use Core\Model;
use Exception;
use InvalidArgumentException;

class Product extends Model
{
    protected $table = 'products';

    public function addProduct($data)
    {
        try {
            if (empty($data['name']) || empty($data['category_id']) || empty($data['brand_id']) || empty($data['price']) || empty($data['stock'])) {
                throw new InvalidArgumentException("All fields are required.");
            }

            if (!empty($_FILES['imagefile']['tmp_name'])) {
                $imagefile = file_get_contents($_FILES['imagefile']['tmp_name']);
            } else {
                $imagefile = null;
            }

            $stmt = $this->db->prepare("INSERT INTO {$this->table} 
            (name, category_id, brand_id, price, stock, description, imagefile) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param(
                "siiddss",
                $data['name'],
                $data['category_id'],
                $data['brand_id'],
                $data['price'],
                $data['stock'],
                $data['description'],
                $imagefile
            );

            if (!is_null($imagefile)) {
                $stmt->send_long_data(6, $imagefile);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAllProducts()
    {
        try {
            $result = $this->db->query("SELECT * FROM {$this->table}" );
            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return $products;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getProductById($id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT p.*, c.name AS category_name, b.name AS brand_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            WHERE p.id = ?
        ");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getProductByName($name)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE name LIKE ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $searchTerm = "%" . $name . "%";
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $totalProducts = $row['total'];

            $productsPerPage = 9;
            $totalPages = ceil($totalProducts / $productsPerPage);

            $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC WHERE name LIKE ? LIMIT 10");
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);

            return ['products' => $products, 'totalPages' => $totalPages];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['products' => [], 'totalPages' => 1];
        }
    }

    public function updateProduct($id, $data)
    {
        try {
            if (empty($data['name']) || empty($data['category_id']) || empty($data['brand_id']) || empty($data['price']) || empty($data['stock'])) {
                throw new InvalidArgumentException("All fields are required.");
            }

            $stmt = $this->db->prepare("UPDATE {$this->table} 
            SET name = ?, category_id = ?, brand_id = ?, price = ?, stock = ?, description = ?, imagefile = ? 
            WHERE id = ?");

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param(
                "siiddssi",
                $data['name'],
                $data['category_id'],
                $data['brand_id'],
                $data['price'],
                $data['stock'],
                $data['description'],
                $data['imagefile'], 
                $id
            );

            if (!is_null($data['imagefile'])) {
                $stmt->send_long_data(6, $data['imagefile']);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getPrice($minPrice, $maxPrice)
    {
        try {
            if (!is_numeric($minPrice) || !is_numeric($maxPrice)) {
                throw new InvalidArgumentException("Invalid price range.");
            }

            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE price > ? AND price <= ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param("dd", $minPrice, $maxPrice);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            return $products;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getCategory($category_id)
    {
        try {
            if (!is_numeric($category_id)) {
                throw new InvalidArgumentException("Invalid category ID.");
            }

            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE category_id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param("i", $category_id);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            return $products;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getProductsWithPagination($perPage, $offset)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC LIMIT ? OFFSET ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param("ii", $perPage, $offset);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            return $products;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getTotalProducts()
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM {$this->table}");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
  
    public function searchAndfilterProducts($search, $perPage, $offset, $filterCategory, $filterBrand, $filterPrice)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE 1=1";

            $params = [];
            $types = '';

            if (!empty($search)) {
                $sql .= " AND name LIKE ?";
                $params[] = "%{$search}%";
                $types .= 's';
            }

            if (!empty($filterCategory)) {
                $categories = is_array($filterCategory) ? $filterCategory : explode(',', $filterCategory);
                $placeholders = implode(',', array_fill(0, count($categories), '?'));
                $sql .= " AND category_id IN ($placeholders)";
                $params = array_merge($params, $categories);
                $types .= str_repeat('i', count($categories));
            }

            if (!empty($filterBrand)) {
                $brands = is_array($filterBrand) ? $filterBrand : explode(',', $filterBrand);
                $placeholders = implode(',', array_fill(0, count($brands), '?'));
                $sql .= " AND brand_id IN ($placeholders)";
                $params = array_merge($params, $brands);
                $types .= str_repeat('i', count($brands));
            }

            if (!empty($filterPrice)) {
                $priceConditions = [];
                $priceRanges = is_array($filterPrice) ? $filterPrice : explode(',', $filterPrice);

                foreach ($priceRanges as $range) {
                    if ($range === 'min-200') {
                        $priceConditions[] = "price < ?";
                        $params[] = 200;
                        $types .= 'd';
                    } elseif ($range === '2000-max') {
                        $priceConditions[] = "price > ?";
                        $params[] = 2000;
                        $types .= 'd';
                    } else {
                        list($minPrice, $maxPrice) = explode('-', $range);
                        $priceConditions[] = "price BETWEEN ? AND ?";
                        $params[] = (float)$minPrice;
                        $params[] = (float)$maxPrice;
                        $types .= 'dd';
                    }
                }

                $sql .= " AND (" . implode(" OR ", $priceConditions) . ")";
            }

            $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
            $params[] = $perPage;
            $params[] = $offset;
            $types .= 'ii';

            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function countSearchandFilterResults($search, $filterCategory, $filterBrand, $filterPrice)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE 1=1";
            $params = [];
            $types = '';

            if (!empty($search)) {
                $sql .= " AND name LIKE ?";
                $params[] = "%{$search}%";
                $types .= 's';
            }

            if (!empty($filterCategory)) {
                $categories = is_array($filterCategory) ? $filterCategory : explode(',', $filterCategory);
                $placeholders = implode(',', array_fill(0, count($categories), '?'));
                $sql .= " AND category_id IN ($placeholders)";
                $params = array_merge($params, $categories);
                $types .= str_repeat('i', count($categories));
            }

            if (!empty($filterBrand)) {
                $brands = is_array($filterBrand) ? $filterBrand : explode(',', $filterBrand);
                $placeholders = implode(',', array_fill(0, count($brands), '?'));
                $sql .= " AND brand_id IN ($placeholders)";
                $params = array_merge($params, $brands);
                $types .= str_repeat('i', count($brands));
            }

            if (!empty($filterPrice)) {
                $priceConditions = [];
                $priceRanges = is_array($filterPrice) ? $filterPrice : explode(',', $filterPrice);

                foreach ($priceRanges as $range) {
                    if ($range === 'min-200') {
                        $priceConditions[] = "price < ?";
                        $params[] = 200;
                        $types .= 'd';
                    } elseif ($range === '2000-max') {
                        $priceConditions[] = "price > ?";
                        $params[] = 2000;
                        $types .= 'd';
                    } else {
                        list($minPrice, $maxPrice) = explode('-', $range);
                        $priceConditions[] = "price BETWEEN ? AND ?";
                        $params[] = (float)$minPrice;
                        $params[] = (float)$maxPrice;
                        $types .= 'dd';
                    }
                }

                $sql .= " AND (" . implode(" OR ", $priceConditions) . ")";
            }

            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
 
    public function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }

}
