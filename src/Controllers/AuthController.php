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
            sleep(2); // Add a 2-second delay for realism
            $id = (int)$_POST['username'];
            $password = $_POST['password'];
            $userModel = new User($this->pdo);
            $user = $userModel->findById($id);

            if ($user && password_verify($password, $user['password_hash'])) {
                session_start(); 
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['last_activity'] = time(); // Set the last activity time
                header("Location: /src/Views/HomePage.php"); // Redirect to HomePage.php
                exit(); // Ensure no further code is executed
            } else {
                $error = "Invalid ID or password.";
            }
        }
        require __DIR__ . '/../Views/Login.php';
    }
}
?>