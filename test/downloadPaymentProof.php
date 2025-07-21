<?php
// Download handler for payment proof files
require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT file_name, file_type, file_blob FROM payment_proofs WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($file) {
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file['file_type']);
        header('Content-Disposition: attachment; filename="' . $file['file_name'] . '"');
        header('Content-Length: ' . strlen($file['file_blob']));
        echo $file['file_blob'];
        exit();
    }
}
echo 'File not found.';
