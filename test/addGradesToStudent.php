<?php

/*
grades:
id: int(11) primary key auto_increment
student_class_id: int(11) foreign key
grade: decimal(4,2)
*/

/*
the purpose of this file is to add grades to a student.
the student_class_id will be used to identify the student and the class they are enrolled in.
it will also be used to identify the term and school year for the grade.
the grade will be a decimal value with 2 decimal places. e.g (1.00, 2.50, 3.75, etc.)
it will be used to display the grades for a student in a specific term and school year.
if no grades, it will be labeled as "NGS" (No Grade Submitted).
*/

/*
 to add a grade to a student, the following fields are required:
 we need to get all the students from the database, and then we need to get all the student classes from the database.
 we will need to filter out selected students. so that it will only show the student that is selected.
*/

require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch all students
$students = $pdo->query("SELECT id, student_number, name FROM students ORDER BY student_number")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all students_class records (with subject/section info)
$student_classes = $pdo->query("SELECT sc.id, s.student_number, s.name AS student_name, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name, sc.term, sc.school_year FROM students_class sc JOIN students s ON sc.student_id = s.id JOIN subjects sub ON sc.subject_id = sub.id JOIN sections sec ON sc.section_id = sec.id ORDER BY s.student_number, sc.term, sc.school_year")->fetchAll(PDO::FETCH_ASSOC);

// Helper function to convert term number to readable text
function getTermText($termNumber) {
    $terms = [1 => '1st Term', 2 => '2nd Term', 3 => '3rd Term'];
    return $terms[$termNumber] ?? "Term $termNumber";
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_grade'])) {
    $student_class_id = $_POST['student_class_id'] ?? '';
    $grade = $_POST['grade'] ?? '';
    if ($student_class_id && $grade !== '') {
        // Check if grade already exists for this students_class_id
        $checkStmt = $pdo->prepare("SELECT id FROM grades WHERE students_class_id = ?");
        $checkStmt->execute([$student_class_id]);
        if ($checkStmt->rowCount() > 0) {
            // Update existing grade
            $stmt = $pdo->prepare("UPDATE grades SET grade = ? WHERE students_class_id = ?");
            $action = "updated";
        } else {
            // Insert new grade
            $stmt = $pdo->prepare("INSERT INTO grades (students_class_id, grade) VALUES (?, ?)");
            $action = "added";
        }
        try {
            if ($action === "updated") {
                $stmt->execute([$grade, $student_class_id]);
            } else {
                $stmt->execute([$student_class_id, $grade]);
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } catch (Exception $e) {
            $message = "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span>";
        }
    } else {
        $message = "<span style='color:red'>All fields are required.</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Grade to Student</title>
</head>
<body>
    <h1>Add Grade to Student</h1>
    <?php if ($message) echo $message; ?>
    <form method="post">
        <label>Student/Class:</label>
        <select name="student_class_id" required>
            <option value="">Select student, subject, section, term, year</option>
            <?php foreach ($student_classes as $sc): ?>
                <option value="<?= htmlspecialchars($sc['id']) ?>">
                    <?= htmlspecialchars($sc['student_number']) ?> - <?= htmlspecialchars($sc['student_name']) ?> | <?= htmlspecialchars($sc['subject_code']) ?> - <?= htmlspecialchars($sc['subject_name']) ?> | <?= htmlspecialchars($sc['section_name']) ?> | <?= htmlspecialchars(getTermText($sc['term'])) ?> | <?= htmlspecialchars($sc['school_year']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Grade:</label>
        <input type="number" name="grade" step="0.01" min="0" max="5" required><br>
        <button type="submit" name="set_grade">Set Grade</button>
    </form>
</body>
</html>