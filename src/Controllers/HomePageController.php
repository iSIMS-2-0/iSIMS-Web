<?php
require_once __DIR__ . '/../Services/AuthService.php';

class HomePageController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showHomePage() {
        // Check authentication using the service
        AuthService::requireAuth();
        
        // Check for session timeout (optional)
        if (AuthService::checkSessionTimeout()) {
            header("Location: /public/index.php?page=login&message=Session expired. Please log in again.");
            exit();
        }
        
        // Render the home page view
        require __DIR__ . '/../Views/HomePage.php';
    }
}

?>