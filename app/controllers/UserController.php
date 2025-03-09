<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function formLoginSignup()
    {
        session_start();
        $this->view('login_signup/login_signup_form');
    }

    public function handleRequest()
    {
        session_start();
        $userModel = new User();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'data_type' => $_POST['data_type'],
                'name' => $_POST['name'] ?? null,
                'password' => $_POST['password'] ?? null,
                'remember' => isset($_POST['remember']),
                'new_name' => $_POST['new_name'] ?? null,
                'new_password' => $_POST['new_password'] ?? null,
                'confirm_password' => $_POST['confirm_password'] ?? null,
                'email' => $_POST['email'] ?? null
            ];

            if ($data['data_type'] === 'login') {
                $userModel->login($data);
            } elseif ($data['data_type'] === 'signup') {
                $userModel->signup($data);
            }
        }
    }

    public function logout()
    {
        session_start();
        $userModel = new User();
        if (isset($_SESSION['session_id'])) {
            $userModel->deleteSession($_SESSION['session_id']);
        }
        session_destroy();
        setcookie('remember_token', '', time() - 3600 * 24 * 7, '/');
        header('Location: /gear_management/public/home/index');
        exit();
    }
}
