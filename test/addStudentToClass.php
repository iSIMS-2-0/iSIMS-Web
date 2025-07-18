<?php

/*
student_class:
id: int(11) primary key auto_increment
student_id: int(11) foreign key to students(id)
subject_id: int(11) foreign key to subjects(id)
section_id: int(11) foreign key to sections(id)
term: varchar(20)
school_year: varchar(20)
*/


/*
purpose of this file:
this file is suppposed to add a enrolled student to a class by student_id, subject_id, section_id, term, and school_year.
it will be used to set the subjects for a student in a section. to be used to display the schedule for a student. in the schedule page.
it will also be used to track the subjects a student is enrolled in for a specific term and school year.

the school year is generated by the current year + 1, e.g., if the current year is 2023, the school year will be 2023-2024.
however, every 2nd to 3rd term, the school year needs to be the same as the 1st term because usually the 2nd term is after the new year eve. Which means that
if 2023-2024 is the school year, then the 2nd term will be 2023-2024, and the 3rd term will be 2023-2024.
*/

// MERGED 

/*
students_schedule:
id: int(11) primary key auto_increment
student_id: int(11) foreign key from students(id)
schedule_id: int(11) foreign key from schedules(id)
*/

/*
the purpose of this file:
this file is supposed to add a student to a schedule by student_id and schedule_id.
it will be used to set the schedule for a student. so that irregular students can be added to a schedule without conflicting with the regular students.
*/



require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch students, subjects, sections
$students = $pdo->query("SELECT id, student_number, name FROM students ORDER BY student_number")->fetchAll(PDO::FETCH_ASSOC);
$subjects = $pdo->query("SELECT id, code, name FROM subjects ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);
$sections = $pdo->query("SELECT id, name FROM sections ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all schedules with details for grouped selection
$schedules = $pdo->query("SELECT schedules.id, sections.name AS section_name, subjects.code AS subject_code, subjects.name AS subject_name, day_of_week, start_time, end_time, room FROM schedules JOIN sections ON schedules.section_id = sections.id JOIN subjects ON schedules.subject_id = subjects.id ORDER BY schedules.day_of_week, schedules.start_time, schedules.room")->fetchAll(PDO::FETCH_ASSOC);

// Organize schedules by section and subject for grouped selection
$organized_schedules = [];
foreach ($schedules as $sched) {
    $section = $sched['section_name'];
    $subject = $sched['subject_code'] . ' - ' . $sched['subject_name'];
    $organized_schedules[$section][$subject][] = $sched;
}

// Determine current term and school year
$year = date('Y');
$next_year = $year + 1;
$school_year = "$year-$next_year";
$terms = [
    1 => '1st Term',
    2 => '2nd Term', 
    3 => '3rd Term'
];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student_class'])) {
    $student_id = $_POST['student_id'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $section_id = $_POST['section_id'] ?? '';
    $term = $_POST['term'] ?? '';
    $school_year_post = $_POST['school_year'] ?? '';
    $schedule_id = $_POST['schedule_id'] ?? '';
    if ($student_id && $subject_id && $section_id && $term && $school_year_post && $schedule_id) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO students_class (student_id, subject_id, section_id, term, school_year) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$student_id, $subject_id, $section_id, $term, $school_year_post]);
            $stmt2 = $pdo->prepare("INSERT INTO student_schedule (studentid, scheduleid) VALUES (?, ?)");
            $stmt2->execute([$student_id, $schedule_id]);
            $pdo->commit();
            $message = "<span style='color:green'>Student enrolled in class and added to schedule.</span>";
        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span>";
        }
    } else {
        $message = "<span style='color:red'>All fields are required.</span>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drop_student_class'])) {
    try {
        $pdo->exec("DELETE FROM students_class");
        $message = "<span style='color:green'>All records dropped from students_class.</span>";
    } catch (Exception $e) {
        $message = "<span style='color:red'>Error dropping students_class: ".htmlspecialchars($e->getMessage())."</span>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drop_students_schedule'])) {
    try {
        $pdo->exec("DELETE FROM student_schedule");
        $message = "<span style='color:green'>All records dropped from student_schedule.</span>";
    } catch (Exception $e) {
        $message = "<span style='color:red'>Error dropping student_schedule: ".htmlspecialchars($e->getMessage())."</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student to Class & Schedule</title>
</head>
<body>
    <h1>Add Student to Class & Schedule</h1>
    <?php if ($message) echo $message; ?>
    <form method="post" id="studentClassForm">
        <label>Student:</label>
        <select name="student_id" required>
            <option value="">Select student</option>
            <?php foreach ($students as $stu): ?>
                <option value="<?= htmlspecialchars($stu['id']) ?>">
                    <?= htmlspecialchars($stu['student_number']) ?> - <?= htmlspecialchars($stu['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Subject:</label>
        <select name="subject_id" id="subjectSelect" required>
            <option value="">Select subject</option>
            <?php foreach ($subjects as $sub): ?>
                <option value="<?= htmlspecialchars($sub['id']) ?>">
                    <?= htmlspecialchars($sub['code']) ?> - <?= htmlspecialchars($sub['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Section:</label>
        <select name="section_id" id="sectionSelect" required>
            <option value="">Select section</option>
            <?php foreach ($sections as $sec): ?>
                <option value="<?= htmlspecialchars($sec['id']) ?>" data-sectioncode="<?= htmlspecialchars($sec['name']) ?>">
                    <?= htmlspecialchars($sec['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Term:</label>
        <select name="term" required>
            <option value="">Select term</option>
            <?php foreach ($terms as $termNum => $termLabel): ?>
                <option value="<?= htmlspecialchars($termNum) ?>"><?= htmlspecialchars($termLabel) ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>School Year:</label>
        <input type="text" name="school_year" value="<?= htmlspecialchars($school_year) ?>" required readonly><br>
        <label>Schedule:</label>
        <select name="schedule_id" id="scheduleSelect" required>
            <option value="">Select schedule</option>
            <?php foreach ($schedules as $sched): ?>
                <option value="<?= htmlspecialchars($sched['id']) ?>" data-subjectcode="<?= htmlspecialchars($sched['subject_code']) ?>" data-sectioncode="<?= htmlspecialchars($sched['section_name']) ?>">
                    <?= htmlspecialchars($sched['subject_code']) ?> | <?= htmlspecialchars($sched['section_name']) ?> | <?= htmlspecialchars($sched['day_of_week']) ?> <?= date('g:i A', strtotime($sched['start_time'])) ?>-<?= date('g:i A', strtotime($sched['end_time'])) ?> | Room: <?= htmlspecialchars($sched['room']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit" name="add_student_class">Add to Class & Schedule</button>
    </form>
    <form method="post" style="margin-top:1em;display:inline;">
        <button type="submit" name="drop_student_class" style="background:#c00;color:#fff;">Drop All student_class</button>
    </form>
    <form method="post" style="margin-top:1em;display:inline;">
        <button type="submit" name="drop_students_schedule" style="background:#c00;color:#fff;">Drop All students_schedule</button>
    </form>
    <script>
    function filterSchedules() {
        var subjectSelect = document.getElementById('subjectSelect');
        var sectionSelect = document.getElementById('sectionSelect');
        var scheduleSelect = document.getElementById('scheduleSelect');
        var subjectText = subjectSelect.options[subjectSelect.selectedIndex]?.text || '';
        var subjectCode = subjectText.split(' - ')[0].trim();
        var sectionText = sectionSelect.options[sectionSelect.selectedIndex]?.text || '';
        var sectionCode = sectionText.trim();
        for (var i = 0; i < scheduleSelect.options.length; i++) {
            var opt = scheduleSelect.options[i];
            if (!opt.value) continue;
            var match = true;
            if (subjectCode && opt.getAttribute('data-subjectcode') !== subjectCode) match = false;
            if (sectionCode && opt.getAttribute('data-sectioncode') !== sectionCode) match = false;
            opt.hidden = !match;
        }
        // If no visible options, reset selection
        if (!Array.from(scheduleSelect.options).some(o => !o.hidden && o.value)) {
            scheduleSelect.value = '';
        }
    }
    document.getElementById('subjectSelect').addEventListener('change', filterSchedules);
    document.getElementById('sectionSelect').addEventListener('change', filterSchedules);
    window.addEventListener('DOMContentLoaded', function() {
        filterSchedules();
    });
    </script>
</body>
</html>