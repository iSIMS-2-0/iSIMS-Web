<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/Models/Grades.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/Models/Schedule.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/config.php";
session_start();
$student_id = $_SESSION['student_id'] ?? null;
$selected_sy = $_GET['schoolYear'] ?? date('Y') . '-' . (date('Y')+1);
$selected_term = $_GET['term'] ?? '1st Term';
$studentGrades = [];
$program = 'N/A';
if ($student_id) {
    $config = require $_SERVER["DOCUMENT_ROOT"] . "/config.php";
    $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['user'], $config['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Get all student_class records for this student, term, and school year
    $stmt = $pdo->prepare("SELECT sc.*, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name, sub.units, g.grade FROM student_class sc JOIN subjects sub ON sc.subject_id = sub.id JOIN sections sec ON sc.section_id = sec.id LEFT JOIN grades g ON g.student_class_id = sc.id WHERE sc.student_id = ? AND sc.term = ? AND sc.school_year = ?");
    $stmt->execute([$student_id, $selected_term, $selected_sy]);
    $studentGrades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Fetch program from students table
    $stmt2 = $pdo->prepare("SELECT program FROM students WHERE id = ?");
    $stmt2->execute([$student_id]);
    $program = $stmt2->fetchColumn() ?: 'N/A';
}
function gradeDisplay($studentGrades){
    foreach ($studentGrades as $grade) {
        echo "<tr>
            <td>{$grade['subject_code']}</td>
            <td>{$grade['subject_name']}</td>
            <td>{$grade['section_name']}</td>
            <td>{$grade['units']}</td>
            <td>" . (isset($grade['grade']) && $grade['grade'] !== null ? number_format($grade['grade'], 2) : 'NGS') . "</td>
        </tr>";
    }
}
function calculateGwa($studentGrades) {
    $totalUnits = 0;
    $totalGrade = 0;
    foreach ($studentGrades as $subject) {
        if (!isset($subject['grade']) || $subject['grade'] === null) continue;
        $units = $subject['units'];
        $grade = $subject['grade'];
        $totalUnits += $units;
        $totalGrade += $units * $grade;
    }
    if ($totalUnits > 0) {
        $gwa = $totalGrade / $totalUnits;
        echo number_format($gwa, 2);
    } else {
        echo 'N/A';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/grades.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Grades</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  
   <div class="mainContainer">
        <div class="contents">
            <h1>Student Grades</h1>
            <form method="get">  
                <div class="selection">
                    <div class="syDiv">
                        <label for="schoolYear">School Year:</label>
                        <select name="schoolYear" id="schoolYear" onchange="this.form.submit()">
                            <option value="<?= htmlspecialchars($selected_sy) ?>"><?= htmlspecialchars($selected_sy) ?></option>
                        </select>
                    </div>
                        <form method="get">
                        <input type="hidden" name="page" value="grades">
                        <div class="termDiv">
                            <label for="term">Term:</label>
                            <select name="term" id="term" onchange="this.form.submit()">
                                <option value="1st Term"<?= $selected_term=='1st Term'?' selected':''; ?>>1st Term</option>
                                <option value="2nd Term"<?= $selected_term=='2nd Term'?' selected':''; ?>>2nd Term</option>
                                <option value="3rd Term"<?= $selected_term=='3rd Term'?' selected':''; ?>>3rd Term</option>
                            </select>
                        </div>
                    </form>
                </div>
            </form>
            <table class = "gradesTable">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Section</th>
                        <th>Units</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php gradeDisplay($studentGrades); ?>
                </tbody>
            </table>
            <table class = "gradeSummary">
                <tr>
                    <th>PROGRAM</th>
                    <td><?= htmlspecialchars($program) ?></td>
                </tr>
                <tr>
                    <th>GWA</th>
                    <td><?php calculateGwa($studentGrades); ?></td>
                </tr>
                <tr>
                    <th>ENROLLMENT STATUS</th>
                    <td>Continuing</td> <!--place holder only, should b server sided-->
                </tr>
            </table>
        </div>
   </div>
</body>
</html>