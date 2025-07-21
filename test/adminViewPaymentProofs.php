<?php
// Simple admin interface to view and approve/reject payment proofs
require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Approve or reject logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proof_id'], $_POST['action'])) {
    $proofId = (int)$_POST['proof_id'];
    $action = $_POST['action'] === 'approve' ? 'received' : 'pending';
    $stmt = $pdo->prepare("UPDATE payment_proofs SET status = ? WHERE id = ?");
    $stmt->execute([$action, $proofId]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Fetch all payment proofs
$stmt = $pdo->query("SELECT p.*, s.student_number, s.name FROM payment_proofs p JOIN students s ON p.student_id = s.id ORDER BY p.upload_date DESC");
$proofs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Payment Proofs</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #aaa; padding: 8px; }
        th { background: #eee; }
        .pending { background: #fff3cd; }
        .received { background: #d4edda; }
    </style>
</head>
<body>
    <h1>Payment Proofs (Admin)</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Number</th>
                <th>Name</th>
                <th>File Name</th>
                <th>Type</th>
                <th>Size (KB)</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Uploaded At</th>
                <th>Download</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proofs as $proof): ?>
                <tr class="<?= htmlspecialchars($proof['status']) ?>">
                    <td><?= $proof['id'] ?></td>
                    <td><?= htmlspecialchars($proof['student_number']) ?></td>
                    <td><?= htmlspecialchars($proof['name']) ?></td>
                    <td><?= htmlspecialchars($proof['file_name']) ?></td>
                    <td><?= htmlspecialchars($proof['file_type']) ?></td>
                    <td><?= round($proof['file_size'] / 1024, 2) ?></td>
                    <td><?= isset($proof['amount']) ? number_format($proof['amount'], 2) : '' ?></td>
                    <td><?= htmlspecialchars(ucfirst($proof['status'] ?? $proof['Status'] ?? '')) ?></td>
                    <td><?= htmlspecialchars($proof['upload_date'] ?? $proof['uploaded_at'] ?? '') ?></td>
                    <td>
                        <a href="downloadPaymentProof.php?id=<?= $proof['id'] ?>" target="_blank">Download</a>
                    </td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="proof_id" value="<?= $proof['id'] ?>">
                            <?php if ($proof['status'] !== 'received'): ?>
                                <button type="submit" name="action" value="approve">Approve</button>
                            <?php endif; ?>
                            <?php if ($proof['status'] !== 'pending'): ?>
                                <button type="submit" name="action" value="pending">Set Pending</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
