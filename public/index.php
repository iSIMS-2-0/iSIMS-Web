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
// $user = new User($pdo);
// $user->createUser(
//     '202301042',
//     'John Doe',
//     'BS Computer Science',
//     'Male',
//     'prefer not to say',
//     '09123456789',
//     '0123456789',
//     'johndoeuwu123@gmail.com',
//     '123 Main St, City, Country',
//     'johndoe123' // Password should be hashed in the model
// );

$controller = new AuthController($pdo);
$controller->login();
?>