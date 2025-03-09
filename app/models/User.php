<?php

namespace App\Models;

use Core\Model;
use Exception;
use InvalidArgumentException;

class User extends Model
{
    protected $table = 'users';

    public function login($data)
    {
        session_start();
        try {
            if (empty($data['name']) || empty($data['password'])) {
                throw new InvalidArgumentException("Name and password are required.");
            }

            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE name = ? LIMIT 1");
            if (!$stmt) {
                throw new Exception("Failed to prepare statement.");
            }

            $stmt->bind_param("s", $data['name']);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute statement.");
            }

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user && password_verify($data['password'], $user['password'])) {
                $_SESSION['name'] = $data['name'];
                if ($data['remember']) {
                    $rememberToken = bin2hex(random_bytes(16));
                    $stmt = $this->db->prepare("UPDATE {$this->table} SET remember_token = ? WHERE id = ?");
                    $stmt->bind_param("si", $rememberToken, $user['id']);
                    $stmt->execute();
                    setcookie('remember_token', $rememberToken, time() + 3600 * 24 * 7, '/');
                }
                $this->createSession($user['id']);
                header("Location: /gear_management/public/home/index");
                exit();
            } else {
                echo "Login failed";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function signup($data)
    {
        session_start();
        try {
            if (empty($data['new_name']) || empty($data['new_password']) || empty($data['confirm_password']) || empty($data['email'])) {
                throw new InvalidArgumentException("All fields are required.");
            }

            if ($data['new_password'] !== $data['confirm_password']) {
                throw new InvalidArgumentException("Passwords do not match.");
            }

            $hashedPassword = password_hash($data['new_password'], PASSWORD_BCRYPT);

            $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, password, email) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Failed to prepare statement.");
            }

            $stmt->bind_param("sss", $data['new_name'], $hashedPassword, $data['email']);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute statement.");
            }
            header("Location: /gear_management/public/user/formLoginSignup");
            exit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function createSession($userId)
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $payload = bin2hex(random_bytes(16));
        $lastActivity = time();

        $stmt = $this->db->prepare("INSERT INTO sessions (user_id, ip_address, user_agent, payload, last_activity) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement.");
        }

        $stmt->bind_param("isssi", $userId, $ipAddress, $userAgent, $payload, $lastActivity);

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute statement.");
        }

        $_SESSION['session_id'] = $this->db->insert_id;
    }

    public function deleteSession($sessionId)
    {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement.");
        }

        $stmt->bind_param("i", $sessionId);

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute statement.");
        }
    }
}
?>