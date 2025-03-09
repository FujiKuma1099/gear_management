<?php

namespace App\Models;

use Core\Model;
use Exception;
use InvalidArgumentException;

class Category extends Model
{
    protected $table = 'categories';
    public function getAllCategories()
    {
        try {
            $result = $this->db->query("SELECT * FROM {$this->table}");
            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            $categories = [];
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }

            return $categories;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getCategoryById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
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
            return null;
        }
    }

    public function getCategoryByName($name)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE name = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("s", $name);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function addCategory($name)
    {
        try {
            if (empty($name)) {
                throw new InvalidArgumentException("Category name cannot be empty.");
            }

            $stmt = $this->db->prepare("INSERT INTO {$this->table} (name) VALUES (?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("s", $name);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateCategory($id, $name)
    {
        try {
            if (empty($name)) {
                throw new InvalidArgumentException("Category name cannot be empty.");
            }
            
            $stmt = $this->db->prepare("UPDATE {$this->table} SET name = ? WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }
            $stmt->bind_param("si", $name, $id);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteCategory($id)
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

    public function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}
