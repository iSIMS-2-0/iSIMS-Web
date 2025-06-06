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
        $student_number = $_POST['username'];
        $password = $_POST['password'];
        $userModel = new User($this->pdo);
        $user = $userModel->findByStudentNumber($student_number);

        if ($user && password_verify($password, $user['password_hash'])) {
            session_start(); 
            $_SESSION['student_number'] = $user['student_number'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['last_activity'] = time();
            header("Location: /src/Views/HomePage.php");
            exit(); 
        } else {
            $error = "Invalid ID or password.";
        }
    }
    require __DIR__ . '/../Views/Login.php';
}
}
?>