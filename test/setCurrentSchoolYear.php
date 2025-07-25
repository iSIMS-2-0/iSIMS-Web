<?php
// Simple UI to set the current school year/term
require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['school_year_id'])) {
        $newCurrentId = (int)$_POST['school_year_id'];
        $pdo->exec("UPDATE school_years SET is_current = 0 WHERE is_current = 1");
        $stmt = $pdo->prepare("UPDATE school_years SET is_current = 1 WHERE id = ?");
        $stmt->execute([$newCurrentId]);
        echo "<span style='color:green'>Current school year/term updated!</span>";
    } elseif (isset($_POST['add_school_year'])) {
        $school_year = $_POST['new_school_year'] ?? '';
        $term = $_POST['new_term'] ?? '';
        if ($school_year && $term) {
            // Check for duplicate
            $dupStmt = $pdo->prepare("SELECT COUNT(*) FROM school_years WHERE school_year = ? AND term = ?");
            $dupStmt->execute([$school_year, $term]);
            if ($dupStmt->fetchColumn() > 0) {
                echo "<span style='color:red'>This school year and term already exists.</span>";
            } else {
                $stmt = $pdo->prepare("INSERT INTO school_years (school_year, term) VALUES (?, ?)");
                $stmt->execute([$school_year, $term]);
                echo "<span style='color:green'>New school year/term added!</span>";
            }
        } else {
            echo "<span style='color:red'>School year and term are required.</span>";
        }
    }
}

// Fetch all school years/terms
$schoolYears = $pdo->query("SELECT * FROM school_years ORDER BY school_year DESC, term DESC")->fetchAll(PDO::FETCH_ASSOC);
$currentId = null;
foreach ($schoolYears as $sy) {
    if ($sy['is_current']) {
        $currentId = $sy['id'];
        break;
    }
}
// For new school year default
$currentYear = date('Y');
$nextYear = $currentYear + 1;
$defaultSchoolYear = $currentYear . '-' . $nextYear;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Current School Year/Term</title>
</head>
<body>
    <h1>Set Current School Year/Term</h1>
    <form method="post">
        <label for="school_year_id">Select School Year/Term:</label>
        <select name="school_year_id" id="school_year_id">
            <?php foreach ($schoolYears as $sy): ?>
                <option value="<?= $sy['id'] ?>" <?= $sy['id'] == $currentId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sy['school_year']) ?> - Term <?= htmlspecialchars($sy['term']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Set as Current</button>
    </form>

    <hr>
    <h2>Add New School Year/Term</h2>
    <form method="post">
        <input type="hidden" name="add_school_year" value="1">
        <label for="new_school_year">School Year:</label>
        <input type="text" name="new_school_year" id="new_school_year" value="<?= htmlspecialchars($defaultSchoolYear) ?>" required>
        <label for="new_term">Term:</label>
        <select name="new_term" id="new_term" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <button type="submit">Add School Year/Term</button>
    </form>
    <hr>
    <h2>All School Years/Terms</h2>
    <table border="1" cellpadding="5">
        <tr><th>School Year</th><th>Term</th><th>Current?</th></tr>
        <?php foreach ($schoolYears as $sy): ?>
            <tr>
                <td><?= htmlspecialchars($sy['school_year']) ?></td>
                <td>Term <?= htmlspecialchars($sy['term']) ?></td>
                <td><?= $sy['is_current'] ? '<b>Yes</b>' : 'No' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
