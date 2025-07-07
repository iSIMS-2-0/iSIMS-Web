<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: /public/index.php?page=login");
    exit();
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/config.php";
$config = require $_SERVER["DOCUMENT_ROOT"] . "/config.php";
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get student's program
$stmt = $pdo->prepare("SELECT program_id FROM students WHERE id = ?");
$stmt->execute([$_SESSION['student_id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
$program_id = $student['program_id'];

// Get curriculum subjects for the student's program with year and term info
$curriculumStmt = $pdo->prepare("
    SELECT s.code, s.name, s.units, c.year_level, c.term_number
    FROM curriculum c 
    JOIN subjects s ON c.subjectid = s.id 
    WHERE c.programid = ? 
    ORDER BY c.year_level ASC, c.term_number ASC, s.code ASC
");
$curriculumStmt->execute([$program_id]);
$curriculumSubjects = $curriculumStmt->fetchAll(PDO::FETCH_ASSOC);

// Organize subjects by year and term dynamically from database
$subjectsByYearTerm = [];
foreach ($curriculumSubjects as $subject) {
    $year = $subject['year_level'] ?? 1;
    $term = $subject['term_number'] ?? 1;
    
    $yearText = getYearText($year);
    $termText = getTermText($term);
    
    if (!isset($subjectsByYearTerm[$yearText])) {
        $subjectsByYearTerm[$yearText] = [];
    }
    if (!isset($subjectsByYearTerm[$yearText][$termText])) {
        $subjectsByYearTerm[$yearText][$termText] = [];
    }
    
    $subjectsByYearTerm[$yearText][$termText][] = $subject;
}

// Create a lookup array for quick subject access
$subjectLookup = [];
foreach ($curriculumSubjects as $subject) {
    $subjectLookup[$subject['code']] = $subject;
}

// Get selected filters
$selectedYear = $_GET['school-year'] ?? '';
$selectedTerm = $_GET['year-term'] ?? '';

// Helper functions
function getYearText($yearNumber) {
    $years = [1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'];
    return $years[$yearNumber] ?? "{$yearNumber}th Year";
}

function getTermText($termNumber) {
    $terms = [1 => '1st Term', 2 => '2nd Term', 3 => '3rd Term'];
    return $terms[$termNumber] ?? "{$termNumber}th Term";
}

function getTermNumber($termText) {
    return str_replace(['1st Term', '2nd Term', '3rd Term'], ['1st term', '2nd term', '3rd term'], $termText);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Registration/curriculum.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Curriculum</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Curriculum</h1>

            <form method="get">
                <div class="selection">
                    <div class="school-year">
                        <label for="school-year">School Year:</label>
                        <select name="school-year" id="school-year__select" onchange="this.form.submit()">
                            <option value="" <?= $selectedYear === '' ? 'selected' : '' ?>>All Years</option>
                            <option value="1st Year" <?= $selectedYear === '1st Year' ? 'selected' : '' ?>>1st Year</option>
                            <option value="2nd Year" <?= $selectedYear === '2nd Year' ? 'selected' : '' ?>>2nd Year</option>
                            <option value="3rd Year" <?= $selectedYear === '3rd Year' ? 'selected' : '' ?>>3rd Year</option>
                            <option value="4th Year" <?= $selectedYear === '4th Year' ? 'selected' : '' ?>>4th Year</option>
                        </select>
                    </div>

                    <div class="year-term">
                        <label for="year-term">Term:</label>
                        <select name="year-term" id="year-term__select" onchange="this.form.submit()">
                            <option value="" <?= $selectedTerm === '' ? 'selected' : '' ?>>All Terms</option>
                            <option value="1st term" <?= $selectedTerm === '1st term' ? 'selected' : '' ?>>1st Term</option>
                            <option value="2nd term" <?= $selectedTerm === '2nd term' ? 'selected' : '' ?>>2nd Term</option>
                            <option value="3rd term" <?= $selectedTerm === '3rd term' ? 'selected' : '' ?>>3rd Term</option>
                        </select>
                    </div>
                </div>
            </form>

           
            <div class="tables">
                <table class="curriculum-table">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Description</th>
                            <th>Pre-requisite</th>
                            <th>Units</th>
                        </tr>
                    </thead>

                    <tbody class="curriculum-table__body">
                        <?php 
                        $hasResults = false;
                        
                        foreach ($subjectsByYearTerm as $year => $terms) {
                            // Skip if year filter is set and doesn't match
                            if ($selectedYear && $selectedYear !== $year) continue;
                            
                            foreach ($terms as $term => $subjects) {
                                // Skip if term filter is set and doesn't match
                                if ($selectedTerm && getTermNumber($term) !== $selectedTerm) continue;
                                
                                // Display year/term header if there are subjects
                                if (!empty($subjects)) {
                                    $hasResults = true;
                                    
                                    // Display year/term header row
                                    echo "<tr class='year-term-header'>";
                                    echo "<td colspan='4' style='background-color: #f0f0f0; font-weight: bold; text-align: center; padding: 10px;'>";
                                    echo htmlspecialchars($year . " - " . $term);
                                    echo "</td>";
                                    echo "</tr>";
                                    
                                    // Display subjects for this year/term
                                    foreach ($subjects as $subject) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($subject['code']) . "</td>";
                                        echo "<td>" . htmlspecialchars($subject['name']) . "</td>";
                                        echo "<td></td>"; // Pre-requisite column (empty for now)
                                        echo "<td>" . htmlspecialchars($subject['units']) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                        }
                        
                        // If no subjects found, display a message
                        if (!$hasResults) {
                            echo "<tr>";
                            echo "<td colspan='4' style='text-align: center; color: #666; font-style: italic; padding: 20px;'>";
                            echo "No subjects found for the selected criteria.";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <table class="legend-table">
                    <thead>
                        <tr>
                            <th colspan="2">Legend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="box-color passed"></td>
                            <td>Already Passed</td>
                        </tr>

                        <tr>
                            <td class="box-color not-taken"></td>
                            <td>Not Yet Taken</td>
                        </tr>

                        <tr>
                            <td class="box-color enrolled"></td>
                            <td>Currently Enrolled</td>
                        </tr>
                        
                        <tr>
                            <td class="box-color failed"></td>
                            <td>Failed</td>
                        </tr>
                    </tbody>

                 </table>
            </div>
        </div>
    </div>
</body>
</html>