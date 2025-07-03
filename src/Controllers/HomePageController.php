<?php

class HomePageController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showHomePage() {
        // Check if the user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // idk maybe process some shit here
        // but for now
        // Render the home page view
       require __DIR__ . '/../Views/HomePage.php';
    }
}

?>