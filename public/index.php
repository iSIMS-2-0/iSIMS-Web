<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Simple router
// $uri = $_SERVER['REQUEST_URI'];
// echo "<h2>Debug: URI = " . htmlspecialchars($uri) . "</h2>";
$controller = new AuthController($pdo);
$controller->login();
// $userModel = new User($pdo);
// $userModel->createUser(202301043, 'securepassword123');
?>