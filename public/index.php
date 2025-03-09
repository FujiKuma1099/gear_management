<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Require Composer autoload
require_once __DIR__ . '/../config/database.php';

$router = new Core\Route(); // Sử dụng namespace Core
$router->run();
