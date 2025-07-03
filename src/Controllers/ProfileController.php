<?php

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

        $config = require $_SERVER["DOCUMENT_ROOT"] . "/config.php";
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch grades
        $stmt = $pdo->prepare("SELECT sc.*, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name, sub.units, g.grade FROM student_class sc JOIN subjects sub ON sc.subject_id = sub.id JOIN sections sec ON sc.section_id = sec.id LEFT JOIN grades g ON g.student_class_id = sc.id WHERE sc.student_id = ? AND sc.term = ? AND sc.school_year = ?");
        $stmt->execute([$student_id, $selected_term, $selected_sy]);
        $studentGrades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch program
        $stmt2 = $pdo->prepare("SELECT program FROM students WHERE id = ?");
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
        require __DIR__ . '/../Views/Profile/Schedule.php';
    }

}

?>