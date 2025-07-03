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