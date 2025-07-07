<?php
require_once __DIR__ . '/../config.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = '';
$confirmDelete = $_POST['confirm_delete'] ?? false;

// Define the test student numbers that were created
$testStudentNumbers = [
    // BSCS Test Accounts
    '202401001', // Juan Carlos Dela Cruz (2nd Year BSCS)
    '202301002', // Maria Sophia Santos (3rd Year BSCS)
    '202201003', // Alexander James Rodriguez (4th Year BSCS)
    
    // BSSE Test Accounts
    '202401501', // John Michael Santos (2nd Year BSSE)
    '202301502', // Maria Elena Rodriguez (3rd Year BSSE)
    '202201503'  // Alexander James Torres (4th Year BSSE)
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $confirmDelete) {
    try {
        $pdo->beginTransaction();
        
        $deletedStudents = [];
        $notFoundStudents = [];
        
        foreach ($testStudentNumbers as $studentNumber) {
            // Find student by student_number
            $stmt = $pdo->prepare('SELECT id, name, family_info_id, medical_historyid FROM students WHERE student_number = ?');
            $stmt->execute([$studentNumber]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($student) {
                $student_id = $student['id'];
                $student_name = $student['name'];
                $family_info_id = $student['family_info_id'];
                $medical_historyid = $student['medical_historyid'];
                
                // Delete in proper order to respect foreign key constraints
                
                // 1. Delete grades (through students_class relationship)
                $stmt = $pdo->prepare('DELETE g FROM grades g JOIN students_class sc ON g.students_class_id = sc.id WHERE sc.student_id = ?');
                $stmt->execute([$student_id]);
                
                // 2. Delete students_class records
                $stmt = $pdo->prepare('DELETE FROM students_class WHERE student_id = ?');
                $stmt->execute([$student_id]);
                
                // 3. Delete student_schedule records (if any)
                $stmt = $pdo->prepare('DELETE FROM student_schedule WHERE studentid = ?');
                $stmt->execute([$student_id]);
                
                // 4. Delete the student record
                $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
                $stmt->execute([$student_id]);
                
                // 5. Delete family_info record
                if ($family_info_id) {
                    $stmt = $pdo->prepare('DELETE FROM family_info WHERE id = ?');
                    $stmt->execute([$family_info_id]);
                }
                
                // 6. Delete medical_history record
                if ($medical_historyid) {
                    $stmt = $pdo->prepare('DELETE FROM medical_history WHERE id = ?');
                    $stmt->execute([$medical_historyid]);
                }
                
                $deletedStudents[] = [
                    'number' => $studentNumber,
                    'name' => $student_name
                ];
            } else {
                $notFoundStudents[] = $studentNumber;
            }
        }
        
        $pdo->commit();
        
        if (!empty($deletedStudents)) {
            $message .= "<div style='color: green; font-weight: bold; margin: 20px 0;'>✅ Successfully deleted the following test accounts:</div>";
            $message .= "<ul style='color: green;'>";
            foreach ($deletedStudents as $student) {
                $message .= "<li><strong>{$student['number']}</strong> - {$student['name']}</li>";
            }
            $message .= "</ul>";
        }
        
        if (!empty($notFoundStudents)) {
            $message .= "<div style='color: orange; margin: 20px 0;'>⚠️ The following student numbers were not found:</div>";
            $message .= "<ul style='color: orange;'>";
            foreach ($notFoundStudents as $studentNumber) {
                $message .= "<li>{$studentNumber}</li>";
            }
            $message .= "</ul>";
        }
        
        if (empty($deletedStudents) && empty($notFoundStudents)) {
            $message = "<div style='color: blue; margin: 20px 0;'>ℹ️ No test accounts found to delete.</div>";
        }
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "<div style='color: red; font-weight: bold; margin: 20px 0;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Check if test accounts exist
$existingAccounts = [];
try {
    foreach ($testStudentNumbers as $studentNumber) {
        $stmt = $pdo->prepare('SELECT s.student_number, s.name, p.course_code FROM students s JOIN program p ON s.program_id = p.id WHERE s.student_number = ?');
        $stmt->execute([$studentNumber]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($student) {
            $existingAccounts[] = $student;
        }
    }
} catch (Exception $e) {
    $message = "<div style='color: red; margin: 20px 0;'>Error checking accounts: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Test Accounts</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f5f5f5;
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #d32f2f;
            margin-bottom: 30px;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #f39c12;
        }
        .danger-box {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #dc3545;
        }
        .info-box {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #17a2b8;
        }
        .account-list {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .account-item {
            padding: 10px;
            margin: 5px 0;
            background: white;
            border-radius: 3px;
            border-left: 4px solid #007bff;
        }
        .delete-button {
            background: #dc3545;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .delete-button:hover {
            background: #c82333;
        }
        .delete-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        .cancel-button {
            background: #6c757d;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-right: 15px;
        }
        .cancel-button:hover {
            background: #5a6268;
            text-decoration: none;
            color: white;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .checkbox-container {
            margin: 20px 0;
            text-align: center;
        }
        .checkbox-container input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 10px;
        }
        .checkbox-container label {
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗑️ Delete Test Accounts</h1>
            <p>Remove BSCS and BSSE test student accounts created by test scripts</p>
        </div>
        
        <?= $message ?>
        
        <?php if (!empty($existingAccounts)): ?>
            <div class="danger-box">
                <h3>⚠️ Warning: Irreversible Action</h3>
                <p><strong>This action will permanently delete the following test accounts and ALL related data:</strong></p>
                <ul>
                    <li>Student personal information</li>
                    <li>Family information</li>
                    <li>Medical history</li>
                    <li>All enrollment records</li>
                    <li>All grades</li>
                    <li>All schedule assignments</li>
                </ul>
            </div>

            <div class="info-box">
                <h3>📋 Test Accounts Found</h3>
                <p>The following test accounts were found in the database:</p>
                <div class="account-list">
                    <?php foreach ($existingAccounts as $account): ?>
                        <div class="account-item">
                            <strong><?= htmlspecialchars($account['student_number']) ?></strong> - 
                            <?= htmlspecialchars($account['name']) ?> 
                            <span style="background: #007bff; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.8em; margin-left: 10px;">
                                <?= htmlspecialchars($account['course_code']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <form method="post" onsubmit="return confirmDeletion()">
                <div class="checkbox-container">
                    <input type="checkbox" id="confirm_checkbox" name="confirm_delete" value="1" required>
                    <label for="confirm_checkbox">
                        I understand this action cannot be undone and will permanently delete all test accounts and related data
                    </label>
                </div>

                <div class="button-container">
                    <a href="/test/" class="cancel-button">Cancel</a>
                    <button type="submit" class="delete-button" id="delete_btn" disabled>
                        🗑️ Delete All Test Accounts
                    </button>
                </div>
            </form>

        <?php else: ?>
            <div class="info-box">
                <h3>ℹ️ No Test Accounts Found</h3>
                <p>No test accounts were found in the database. The test accounts may have already been deleted or were never created.</p>
                <p>Expected test account numbers:</p>
                <ul>
                    <li><strong>202401001</strong> - Juan Carlos Dela Cruz (2nd Year BSCS)</li>
                    <li><strong>202301002</strong> - Maria Sophia Santos (3rd Year BSCS)</li>
                    <li><strong>202201003</strong> - Alexander James Rodriguez (4th Year BSCS)</li>
                    <li><strong>202401501</strong> - John Michael Santos (2nd Year BSSE)</li>
                    <li><strong>202301502</strong> - Maria Elena Rodriguez (3rd Year BSSE)</li>
                    <li><strong>202201503</strong> - Alexander James Torres (4th Year BSSE)</li>
                </ul>
            </div>
            
            <div class="button-container">
                <a href="/test/" class="cancel-button">Back to Test Menu</a>
                <a href="/test/createTestAccounts.php" class="delete-button" style="background: #28a745; text-decoration: none; margin-right: 10px;">
                    ➕ Create BSCS Accounts
                </a>
                <a href="/test/createBSSETestAccounts.php" class="delete-button" style="background: #6f42c1; text-decoration: none;">
                    ➕ Create BSSE Accounts
                </a>
            </div>
        <?php endif; ?>

        <div class="warning-box" style="margin-top: 30px;">
            <h4>💡 Alternative: Individual Account Deletion</h4>
            <p>If you want to delete accounts individually, you can use the <strong>createAccountTest.php</strong> tool which has a "Drop Student" feature for single account deletion.</p>
            <p><a href="/test/createAccountTest.php" style="color: #007bff;">Go to Individual Account Management →</a></p>
        </div>
    </div>

    <script>
        function confirmDeletion() {
            return confirm('Are you absolutely sure you want to delete ALL test accounts? This action cannot be undone!');
        }

        // Enable/disable delete button based on checkbox
        document.getElementById('confirm_checkbox').addEventListener('change', function() {
            document.getElementById('delete_btn').disabled = !this.checked;
        });
    </script>
</body>
</html>
