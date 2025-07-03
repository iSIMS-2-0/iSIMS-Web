<?php
require_once __DIR__ . '/../Models/Schedule.php';
require_once __DIR__ . '/../Models/Grades.php';
require_once __DIR__ . '/../Models/User.php';
class ProfileController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showProfile() {
        session_start();
        if (!isset($_SESSION['student_id'])) {
            header("Location: /public/index.php?page=login");
            exit();
        }
        require __DIR__ . '/../Views/Profile.php';
    }

public function showStudentProfile() {
    session_start();
    if (!isset($_SESSION['student_id'])) {
        header("Location: /public/index.php?page=login");
        exit();
    }

    $userModel = new User($this->pdo);
    $user = $userModel->findByStudentNumber($_SESSION['student_number']);
    $family = $userModel->findFamilyInfoByID($user['family_info_id']);
    $medical = $userModel->findMedicalHistoryByID($user['medical_historyid']);

    $emergency = [
        'name' => $family['other_contact_name'] ?? '',
        'mobile' => $family['other_contact_mobilenum'] ?? '',
        'email' => $family['other_contact_email'] ?? ''
    ];
    $isMother = (
        $emergency['name'] === ($family['mother_name'] ?? '') &&
        $emergency['mobile'] === ($family['mother_mobile_number'] ?? '') &&
        $emergency['email'] === ($family['mother_email'] ?? '')
    );
    $isFather = (
        $emergency['name'] === ($family['father_name'] ?? '') &&
        $emergency['mobile'] === ($family['father_mobile_number'] ?? '') &&
        $emergency['email'] === ($family['father_email'] ?? '')
    );

    $success = '';
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize input here!
        $new_email = trim($_POST['studentEmailAddress'] ?? '');
        $new_mother_email = trim($_POST['mothersEmailAddress'] ?? '');
        $new_father_email = trim($_POST['fathersEmailAddress'] ?? '');
        $new_other_email = trim($_POST['otherEmailAddress'] ?? '');
        $new_comorb = trim($_POST['comorbidities'] ?? '');
        $new_allergies = trim($_POST['allergy'] ?? '');
        $new_gender_disclosure = isset($_POST['studentGender']) ? 'yes' : 'no';
        $new_pronoun = $_POST['gender'] ?? '';

        $new_comorb = ($new_comorb === '') ? null : $new_comorb;
        $new_allergies = ($new_allergies === '') ? null : $new_allergies;

        try {
            $stmt = $this->pdo->prepare("UPDATE students SET email = ?, gender_disclosure = ?, pronouns = ? WHERE id = ?");
            $stmt->execute([$new_email, $new_gender_disclosure, $new_pronoun, $user['id']]);
            $stmt = $this->pdo->prepare("UPDATE family_info SET mother_email = ?, father_email = ?, other_contact_email = ? WHERE id = ?");
            $stmt->execute([$new_mother_email, $new_father_email, $new_other_email, $user['family_info_id']]);
            $stmt = $this->pdo->prepare("UPDATE medical_history SET comorb = ?, allergies = ? WHERE id = ?");
            $stmt->execute([$new_comorb, $new_allergies, $user['medical_historyid']]);
            $success = "Profile updated successfully.";
        } catch (Exception $e) {
            $error = "Failed to update profile.";
        }

        // Refresh data after update
        $user = $userModel->findByStudentNumber($_SESSION['student_number']);
        $family = $userModel->findFamilyInfoByID($user['family_info_id']);
        $medical = $userModel->findMedicalHistoryByID($user['medical_historyid']);
    }

    require __DIR__ . '/../Views/Profile/StudentProfile.php';
}
    
    public function showGrades() {
        session_start();
        if (!isset($_SESSION['student_id'])) {
            header("Location: /public/index.php?page=login");
            exit();
        }
        $student_id = $_SESSION['student_id'];
        $selected_sy = $_GET['schoolYear'] ?? date('Y') . '-' . (date('Y')+1);
        $selected_term = $_GET['term'] ?? '1st Term';
        // Fetch grades
        $stmt = $this->pdo->prepare("SELECT sc.*, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name, sub.units, g.grade FROM student_class sc JOIN subjects sub ON sc.subject_id = sub.id JOIN sections sec ON sc.section_id = sec.id LEFT JOIN grades g ON g.student_class_id = sc.id WHERE sc.student_id = ? AND sc.term = ? AND sc.school_year = ?");
        $stmt->execute([$student_id, $selected_term, $selected_sy]);
        $studentGrades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch program
        $stmt2 = $this->pdo->prepare("SELECT program FROM students WHERE id = ?");
        $stmt2->execute([$student_id]);
        $program = $stmt2->fetchColumn() ?: 'N/A';

        // Pass data to view
        require __DIR__ . '/../Views/Profile/Grades.php';
    }

    public function showSchedule() {
        session_start();
        if (!isset($_SESSION['student_id'])) {
            header("Location: /public/index.php?page=login");
            exit();
        }
        // Assume student_id is stored in session after login
        $student_id = $_SESSION['student_id'] ?? null;

        $scheduleData = [];

        $scheduleModel = new Schedule($this->pdo);
        // Get the latest/current term and school year for this student
        $stmt = $this->pdo->prepare("SELECT sc.term, sc.school_year FROM student_class sc WHERE sc.student_id = ? ORDER BY sc.school_year DESC, FIELD(sc.term, '1st Term', '2nd Term', '3rd Term') DESC LIMIT 1");
        $stmt->execute([$student_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_term = $row['term'] ?? null;
        $current_sy = $row['school_year'] ?? null;
        if ($current_term && $current_sy) {
            $studentSchedules = $this->pdo->prepare("SELECT s.*, sc.term, sc.school_year, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name FROM students_schedule ss JOIN schedules s ON ss.schedule_id = s.id JOIN student_class sc ON sc.student_id = ss.student_id AND sc.subject_id = s.subject_id AND sc.section_id = s.section_id JOIN subjects sub ON s.subject_id = sub.id JOIN sections sec ON s.section_id = sec.id WHERE ss.student_id = ? AND sc.term = ? AND sc.school_year = ?");
            $studentSchedules->execute([$student_id, $current_term, $current_sy]);
            $scheduleData = $studentSchedules->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $scheduleData = [];
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
        require __DIR__ . '/../Views/Profile/Schedule.php';
    }

}

?>