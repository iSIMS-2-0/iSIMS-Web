<?php

class ConcernsController {
        private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showConcerns() {
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Render the ERF view
        require __DIR__ . '/../Views/ConcernsFeedback/concernsFeedback.php';
    }
}
?>