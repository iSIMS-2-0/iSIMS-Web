<?php
class PaymentController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showERF() {
        // Start session to check if user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Render the ERF view
        require __DIR__ . '/../Views/Payment/erf.php';
    }

    public function showPaymentHistory() {
        // Start session to check if user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Render the payment history view
        require __DIR__ . '/../Views/Payment/onlinePayment.php';
    }

    public function showOnlinePayment() {
        // Start session to check if user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Render the online payment view
        require __DIR__ . '/../Views/Payment/paymentHistory.php';
    }
}

?>