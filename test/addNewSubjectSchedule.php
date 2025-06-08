<?php

/*
Schedules:
id: primary_key auto_increment
section_id: int(11) foreign key to sections(id)
subject_id: int(11) foreign key to subjects(id)
day_of_week: varchar(10) (e.g., 'Monday', 'Tuesday', etc.)
start_time: time
end_time: time
room: varchar(50)
*/

/*
    this file should set the schedule by section, subject, day of week, start time, end time, and room.
    it will be used to set the schedule for a section/subject.
*/

require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch all sections and subjects
$sections = $pdo->query("SELECT id, name FROM sections ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$subjects = $pdo->query("SELECT id, code, name FROM subjects ORDER BY code")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all schedules for deletion
$schedules = $pdo->query("SELECT schedules.id, sections.name AS section_name, subjects.code AS subject_code, subjects.name AS subject_name, day_of_week, start_time, end_time, room FROM schedules JOIN sections ON schedules.section_id = sections.id JOIN subjects ON schedules.subject_id = subjects.id ORDER BY schedules.id DESC")->fetchAll(PDO::FETCH_ASSOC);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_schedule'])) {
    $section_id = $_POST['section_id'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $day_of_week = $_POST['day_of_week'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $room = $_POST['room'] ?? '';
    if ($section_id && $subject_id && $day_of_week && $start_time && $end_time && $room) {
        // Check for room conflict
        $conflictStmt = $pdo->prepare("SELECT COUNT(*) FROM schedules WHERE room = ? AND day_of_week = ? AND ((start_time < ? AND end_time > ?) OR (start_time < ? AND end_time > ?) OR (start_time >= ? AND end_time <= ?))");
        $conflictStmt->execute([
            $room,
            $day_of_week,
            $end_time, $start_time, // overlap: new start inside existing
            $start_time, $end_time, // overlap: new end inside existing
            $start_time, $end_time  // contained
        ]);
        $conflictCount = $conflictStmt->fetchColumn();
        if ($conflictCount > 0) {
            $message = "<span style='color:red'>Error: There is already a schedule in this room at the selected time.</span>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO schedules (section_id, subject_id, day_of_week, start_time, end_time, room) VALUES (?, ?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$section_id, $subject_id, $day_of_week, $start_time, $end_time, $room]);
                $message = "<span style='color:green'>Schedule set for section/subject!</span>";
            } catch (Exception $e) {
                $message = "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span>";
            }
        }
    } else {
        $message = "<span style='color:red'>All fields are required.</span>";
    }
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_schedule'])) {
    $schedule_id = $_POST['schedule_id'] ?? '';
    if ($schedule_id) {
        $stmt = $pdo->prepare("DELETE FROM schedules WHERE id = ?");
        try {
            $stmt->execute([$schedule_id]);
            $message = "<span style='color:green'>Schedule deleted.</span>";
        } catch (Exception $e) {
            $message = "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span>";
        }
    }
}

// --- TEST SCHEDULES GENERATION (for demo/testing only) ---
if (isset($_GET['generate_test_schedules'])) {
    $days = ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $section_ids = array_column($sections, 'id');
    $subject_ids = array_column($subjects, 'id');
    $count = 0;
    $time_blocks = [
        ['07:30:00', '11:00:00'],
        ['11:00:00', '14:30:00'],
        ['14:30:00', '18:00:00'],
    ];
    foreach ($section_ids as $sec_idx => $section_id) {
        foreach ($days as $day_idx => $day) {
            foreach ($subject_ids as $subject_id) {
                foreach ($time_blocks as $block_idx => $block) {
                    $start_24 = $block[0];
                    $end_24 = $block[1];
                    $room = 'Room ' . (100 + $sec_idx * count($subject_ids) + $block_idx + 1);
                    // No need to check for conflicts, just insert all
                    $stmt = $pdo->prepare("INSERT INTO schedules (section_id, subject_id, day_of_week, start_time, end_time, room) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$section_id, $subject_id, $day, $start_24, $end_24, $room]);
                    $count++;
                }
            }
        }
    }
    $message = "<span style='color:green'>$count test schedules generated (ALL subjects, ALL sections, 3 blocks/day, Tue-Sat, no conflict checks).</span>";
}
// --- DROP ALL SCHEDULES ---
if (isset($_GET['drop_all_schedules'])) {
    try {
        $pdo->exec("ALTER TABLE schedules AUTO_INCREMENT = 1");
        $pdo->exec("DELETE FROM schedules");
        $message = "<span style='color:green'>All schedules dropped.</span>";
    } catch (Exception $e) {
        $message = "<span style='color:red'>Error dropping schedules: ".htmlspecialchars($e->getMessage())."</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Schedule</title>
</head>
<body>
    <h1>Set Section/Subject Schedule</h1>
    <?php if ($message) echo $message; ?>
    <form method="post">
        <label>Section:</label>
        <select name="section_id" required>
            <option value="">Select section</option>
            <?php foreach ($sections as $sec): ?>s
                <option value="<?= htmlspecialchars($sec['id']) ?>">
                    <?= htmlspecialchars($sec['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Subject:</label>
        <select name="subject_id" required>
            <option value="">Select subject</option>
            <?php foreach ($subjects as $sub): ?>
                <option value="<?= htmlspecialchars($sub['id']) ?>">
                    <?= htmlspecialchars($sub['code']) ?> - <?= htmlspecialchars($sub['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Day of Week:</label>
        <select name="day_of_week" required>
            <option value="">Select day</option>
            <option>Monday</option>
            <option>Tuesday</option>
            <option>Wednesday</option>
            <option>Thursday</option>
            <option>Friday</option>
            <option>Saturday</option>
            <option>Sunday</option>
        </select><br>
        <label>Start Time:</label>
        <input type="time" name="start_time" required><br>
        <label>End Time:</label>
        <input type="time" name="end_time" required><br>
        <label>Room:</label>
        <input type="text" name="room" maxlength="50" required><br>
        <button type="submit" name="set_schedule">Set Schedule</button>
    </form>
    <hr>
    <h2>Delete Schedule</h2>
    <form method="post">
        <label>Schedule to Delete:</label>
        <select name="schedule_id" required>
            <option value="">Select schedule</option>
            <?php foreach ($schedules as $sched): ?>
                <option value="<?= htmlspecialchars($sched['id']) ?>">
                    <?= htmlspecialchars($sched['section_name']) ?> | <?= htmlspecialchars($sched['subject_code']) ?> - <?= htmlspecialchars($sched['subject_name']) ?> | <?= htmlspecialchars($sched['day_of_week']) ?> <?= htmlspecialchars($sched['start_time']) ?>-<?= htmlspecialchars($sched['end_time']) ?> | Room: <?= htmlspecialchars($sched['room']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="delete_schedule">Delete Schedule</button>
    </form>
    <hr>
    <form method="get">
        <button type="submit" name="generate_test_schedules" value="1">Generate Test Schedules (No Mon/Sun, 3hr/2hr/1hr, No Room Conflict)</button>
        <button type="submit" name="drop_all_schedules" value="1" style="margin-left:1em;">Drop All Schedules</button>
    </form>
</body>
</html>

