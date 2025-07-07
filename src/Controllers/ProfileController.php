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
    $program = $userModel->findProgramById($user['id']);

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
        $studentData = [
            'email' => trim($_POST['studentEmailAddress'] ?? ''),
            'gender_disclosure' => isset($_POST['studentGender']) ? 1 : 0,
            'pronouns' => $_POST['gender'] ?? ''
        ];
        $familyData = [
            'mother_email' => trim($_POST['mothersEmailAddress'] ?? ''),
            'father_email' => trim($_POST['fathersEmailAddress'] ?? ''),
            'other_contact_email' => trim($_POST['otherEmailAddress'] ?? '')
        ];
        $medicalData = [
            'comorb' => ($c = trim($_POST['comorbidities'] ?? '')) === '' ? null : $c,
            'allergies' => ($a = trim($_POST['allergy'] ?? '')) === '' ? null : $a
        ];
        
        $success = '';
        $error = '';
        $result = $userModel->updateProfileInfo($user['id'], $user['family_info_id'], $user['medical_historyid'], $studentData, $familyData, $medicalData);
        if ($result) {
            $success = "Profile updated successfully.";
        } else {
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
        
        // Fetch grades using Grades model
        $gradesModel = new Grades($this->pdo);
        $studentGrades = $gradesModel->getStudentGrades($student_id, $selected_term, $selected_sy);

        // Fetch program and creation year
        $userModel = new User($this->pdo);
        $program = $userModel->findProgramById($student_id);
        $creationYear = $userModel->getStudentCreationYear($student_id);
        
        // Generate available school years based on account creation year
        $availableSchoolYears = [];
        $currentYear = date('Y');
        for ($year = $creationYear; $year <= $currentYear; $year++) {
            $schoolYear = $year . '-' . ($year + 1);
            $availableSchoolYears[] = $schoolYear;
        }

        // Pass data to view
        require __DIR__ . '/../Views/Profile/Grades.php';
    }

    public function showSchedule() {
        session_start();
        if (!isset($_SESSION['student_id'])) {
            header("Location: /public/index.php?page=login");
            exit();
        }
        
        $student_id = $_SESSION['student_id'] ?? null;
        $selected_sy = $_GET['schoolYear'] ?? date('Y') . '-' . (date('Y')+1);
        $selected_term = $_GET['term'] ?? '1st Term';

        $scheduleModel = new Schedule($this->pdo);
        $scheduleData = $scheduleModel->getStudentScheduleForCurrentTerm($student_id);
        
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
        
        if ($scheduleData) {
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