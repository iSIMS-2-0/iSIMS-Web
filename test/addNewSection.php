<?php


/*
Section:
id: int(11) primary key auto_increment
name: varchar(50)
*/

// Simple form to add a new section
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_section'])) {
    $name = $_POST['name'] ?? '';
    if ($name) {
        require_once __DIR__ . '/../config.php';
        $config = require __DIR__ . '/../config.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO sections (name) VALUES (?)");
        try {
            $stmt->execute([$name]);
            echo "<span style='color:green'>Section added: $name</span><br>";
        } catch (Exception $e) {
            echo "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span><br>";
        }
    }
}
?>
<form method="post">
    <h2>Add New Section</h2>
    Section Name: <input name="name" maxlength="50" required><br>
    <button type="submit" name="add_section">Add Section</button>
</form>