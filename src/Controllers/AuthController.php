<?php
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function login() {
        $error = '';
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['username'];
            $password = $_POST['password'];
            $userModel = new User($this->pdo);
            $user = $userModel->findById($id);
            // Debugging output
            echo "<h2>Debug: User fetched = " . htmlspecialchars(print_r($user, true)) . "</h2>";
            if ($user && $password === $user['password_hash']) { // checks if the credentials are correct
                // maybe some redirection to the dashboard
                // or some other page
                // For now, just a welcome message
                // should use a session to store user data
                // and redirect to a protected page
                session_start(); 
                $_SESSION['user_id'] = $user['id'];
                $message = "Welcome, " . htmlspecialchars($user['name']) . " (ID: " . htmlspecialchars($user['id']) . ")!";
            } else {
                $error = "Invalid ID or password.";
            }
        }
        require __DIR__ . '/../Views/Login.php';
    }
}
?>