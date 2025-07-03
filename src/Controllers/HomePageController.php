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
        
        session_start();
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /public/index.php?message=Please log in to access this page.");
            exit();
        }

        // Check for session timeout
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) { // 600 seconds = 10 minutes
            // Session has expired
            session_unset();
            session_destroy();
            header("Location: /public/index.php?message=Session expired. Please log in again.");
            exit();
        }
        // Update last activity time
        $_SESSION['last_activity'] = time();
       require __DIR__ . '/../Views/HomePage.php';
    }
}

?>