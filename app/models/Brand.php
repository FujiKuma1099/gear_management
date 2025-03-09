<?php

namespace App\Models;

use Core\Model;
use Exception;
use InvalidArgumentException;

class Brand extends Model
{
    protected $table = 'brands';
    public function getAllBrands()
    {
        try {
            $result = $this->db->query("SELECT * FROM {$this->table}");
            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }

            $brands = [];
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row;
            }

            return $brands;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getBrandById($id)
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

    public function getBrandByName($name)
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

    public function addBrand($name)
    {
        try {
            if (empty($name)) {
                throw new InvalidArgumentException("Brand name cannot be empty.");
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

    public function updateBrand($id, $name)
    {
        try {
            if (empty($name)) {
                throw new InvalidArgumentException("Brand name cannot be empty.");
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

    public function deleteBrand($id)
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
