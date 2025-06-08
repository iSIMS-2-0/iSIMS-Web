<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/Models/Schedule.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/config.php";

session_start();
// Assume student_id is stored in session after login
$student_id = $_SESSION['student_id'] ?? null;

// Get selected school year and term from GET or default
$selected_sy = $_GET['schoolYear'] ?? date('Y') . '-' . (date('Y')+1);
$selected_term = $_GET['term'] ?? '1st Term';

$scheduleData = [];
if ($student_id) {
    $config = require $_SERVER["DOCUMENT_ROOT"] . "/config.php";
    $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['user'], $config['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $scheduleModel = new Schedule($pdo);
    // Get all schedule_ids for this student
    $studentSchedules = $pdo->prepare("SELECT s.*, sc.term, sc.school_year, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name FROM students_schedule ss JOIN schedules s ON ss.schedule_id = s.id JOIN student_class sc ON sc.student_id = ss.student_id AND sc.subject_id = s.subject_id AND sc.section_id = s.section_id JOIN subjects sub ON s.subject_id = sub.id JOIN sections sec ON s.section_id = sec.id WHERE ss.student_id = ? AND sc.term = ? AND sc.school_year = ?");
    $studentSchedules->execute([$student_id, $selected_term, $selected_sy]);
    $scheduleData = $studentSchedules->fetchAll(PDO::FETCH_ASSOC);
}
// Helper: organize by day and time block
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
$time_blocks = [
    ['07:30','11:00'],
    ['11:00','14:30'],
    ['14:30','18:00'],
];
$scheduleTable = [];
foreach ($days as $day) {
    foreach ($time_blocks as $block) {
        $scheduleTable[$block[0].'-'.$block[1]][$day] = [];
    }
}
foreach ($scheduleData as $sched) {
    $start = date('g:i A', strtotime($sched['start_time']));
    $end = date('g:i A', strtotime($sched['end_time']));
    $blockKey = date('H:i', strtotime($sched['start_time'])) . '-' . date('H:i', strtotime($sched['end_time']));
    $day = $sched['day_of_week'];
    $info = $sched['subject_code'] . "<br>" . $sched['section_name'] . "<br>" . $sched['room'];
    if (isset($scheduleTable[$blockKey][$day])) {
        $scheduleTable[$blockKey][$day][] = $info;
    }
}
// For display, use AM/PM format for block labels
$display_blocks = [
    ['07:30 AM','11:00 AM'],
    ['11:00 AM','2:30 PM'],
    ['2:30 PM','6:00 PM'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/schedule.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Schedule</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

   <div class="mainContainer">
     <div class="contents">
        <h1>Schedule</h1>
        <form method="get">  
            <div class="selection">
            <div class="syDiv">
                    <label for="schoolYear">School Year:</label>
                    <select name="schoolYear" id="schoolYear" onchange="this.form.submit()">
                        <option value="<?= htmlspecialchars($selected_sy) ?>"><?= htmlspecialchars($selected_sy) ?></option>
                    </select>
            </div>
                <div class="termDiv">
                    <label for="term">Term:</label>
                    <select name="term" id="term" onchange="this.form.submit()">
                        <option value="1st Term"<?= $selected_term=='1st Term'?' selected':''; ?>>1st Term</option>
                        <option value="2nd Term"<?= $selected_term=='2nd Term'?' selected':''; ?>>2nd Term</option>
                        <option value="3rd Term"<?= $selected_term=='3rd Term'?' selected':''; ?>>3rd Term</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="scheduleTable">
            <table>
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($days as $day): ?>
                        <th><?= htmlspecialchars($day) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($time_blocks as $i => $block): $blockKey = $block[0].'-'.$block[1]; ?>
                <tr>
                    <td><?= htmlspecialchars($display_blocks[$i][0] . ' - ' . $display_blocks[$i][1]) ?></td>
                    <?php foreach ($days as $day): ?>
                        <td>
                            <?php 
                            if (!empty($scheduleTable[$blockKey][$day])) {
                                echo implode('<hr>', $scheduleTable[$blockKey][$day]); 
                            } else {
                                echo '<div class="emptyCellPlaceholder"></div>';
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
     </div>
   </div>
</body>
</html>