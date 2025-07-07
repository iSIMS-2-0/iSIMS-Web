<?php
require_once __DIR__ . '/../config.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $program_name = $_POST['program_name'] ?? '';
    $course_code = $_POST['course_code'] ?? '';
    
    if (!empty($program_name) && !empty($course_code)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO program (program_name, course_code) VALUES (?, ?)");
            $stmt->execute([$program_name, $course_code]);
            $message = "<span style='color:green'>Program added successfully!</span>";
        } catch (Exception $e) {
            $message = "<span style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
        }
    } else {
        $message = "<span style='color:red'>Please fill in all fields.</span>";
    }
}

// Fetch all programs
$stmt = $pdo->query("SELECT * FROM program ORDER BY program_name");
$programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Programs Test</title>
</head>
<body>
    <h1>Manage Programs</h1>
    <?php if ($message) echo $message; ?>
    
    <h2>Add New Program</h2>
    <form method="post">
        Program Name: <input name="program_name" required><br><br>
        Course Code: <input name="course_code" required><br><br>
        <button type="submit">Add Program</button>
    </form>
    
    <h2>Existing Programs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Program Name</th>
            <th>Course Code</th>
        </tr>
        <?php foreach ($programs as $program): ?>
        <tr>
            <td><?= $program['id'] ?></td>
            <td><?= htmlspecialchars($program['program_name']) ?></td>
            <td><?= htmlspecialchars($program['course_code']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
