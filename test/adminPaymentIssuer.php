<?php
// Admin Payment Issuer for Students
require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = '';

// Fetch all students
$students = $pdo->query("SELECT id, student_number, name FROM students ORDER BY student_number")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issue_payment'])) {
    $student_id = $_POST['student_id'] ?? '';
    $desc = $_POST['description'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $school_year = $_POST['school_year'] ?? '';
    $term = isset($_POST['term']) ? (int)$_POST['term'] : '';
    if ($student_id && $desc && $amount && $school_year && $term !== '') {
        // Safe placeholders for NOT NULL file columns
        $safeFileName = 'admin_placeholder.pdf';
        $safeFileType = 'application/pdf';
        $safeFileSize = 1;
        $safeFileBlob = ' ';
        $stmt = $pdo->prepare("INSERT INTO payment_proofs (student_id, payment_description, school_year, term, amount, file_name, file_type, file_size, file_blob, status, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$student_id, $desc, $school_year, $term, $amount, $safeFileName, $safeFileType, $safeFileSize, $safeFileBlob, 'Pending']);
        $message = "<span style='color:green'>Payment issued to student ID $student_id</span>";
    } else {
        $message = "<span style='color:red'>All fields are required.</span>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_payment'])) {
    $payment_id = $_POST['payment_id'] ?? '';
    $new_amount = $_POST['new_amount'] ?? '';
    $new_status = $_POST['new_status'] ?? '';
    if ($payment_id && $new_amount && $new_status) {
        $stmt = $pdo->prepare("UPDATE payment_proofs SET amount = ?, status = ? WHERE id = ?");
        $stmt->execute([$new_amount, $new_status, $payment_id]);
        $message = "<span style='color:green'>Payment updated.</span>";
    } else {
        $message = "<span style='color:red'>All fields are required for update.</span>";
    }
}

// Fetch all issued payments
$payments = $pdo->query("SELECT p.*, s.student_number, s.name FROM payment_proofs p JOIN students s ON p.student_id = s.id ORDER BY p.upload_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Payment Issuer</title>
</head>
<body>
    <h1>Admin Payment Issuer</h1>
    <?php if ($message) echo $message; ?>
    <h2>Issue Payment to Student</h2>
    <form method="post">
        Student:
        <select name="student_id" required>
            <option value="">Select Student</option>
            <?php foreach ($students as $stu): ?>
                <option value="<?= $stu['id'] ?>">[<?= htmlspecialchars($stu['student_number']) ?>] <?= htmlspecialchars($stu['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        Description: <input name="description" required><br>
        Amount: <input name="amount" type="number" step="0.01" required><br>
        School Year: <input name="school_year" required placeholder="e.g. 2025-2026"><br>
        Term: <input name="term" type="number" min="1" max="3" required placeholder="e.g. 1 (integer)"><br>
        <button type="submit" name="issue_payment">Issue Payment</button>
    </form>

    <h2>Update Existing Payment</h2>
    <form method="post">
        Payment ID: <input name="payment_id" required><br>
        New Amount: <input name="new_amount" type="number" step="0.01" required><br>
        New Status:
        <select name="new_status" required>
            <option value="Pending">Pending</option>
            <option value="Partial">Partial</option>
            <option value="Approved">Approved</option>
            <option value="Received">Received</option>
        </select><br>
        <button type="submit" name="update_payment">Update Payment</button>
    </form>

    <h2>All Issued Payments</h2>
    <table border="1" cellpadding="4">
        <tr>
            <th>ID</th><th>Student</th><th>Description</th><th>Amount</th><th>Status</th><th>School Year</th><th>Term</th><th>Date</th>
        </tr>
        <?php foreach ($payments as $pay): ?>
            <tr>
                <td><?= $pay['id'] ?></td>
                <td>[<?= htmlspecialchars($pay['student_number']) ?>] <?= htmlspecialchars($pay['name']) ?></td>
                <td><?= htmlspecialchars($pay['payment_description']) ?></td>
                <td><?= number_format($pay['amount'], 2) ?></td>
                <td><?= htmlspecialchars($pay['status']) ?></td>
                <td><?= htmlspecialchars($pay['school_year']) ?></td>
                <td><?= htmlspecialchars($pay['term']) ?></td>
                <td><?= htmlspecialchars($pay['upload_date']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
