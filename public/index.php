<?php

echo "<h3>Debug Information:</h3>";
echo "<strong>Current working directory:</strong> " . getcwd() . "<br>";
echo "<strong>__DIR__ (current file directory):</strong> " . __DIR__ . "<br>";
echo "<strong>__FILE__ (current file path):</strong> " . __FILE__ . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "<strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>HTTP Host:</strong> " . $_SERVER['HTTP_HOST'] . "<br>";
echo "<hr>";


$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'home':
        require_once __DIR__ . '/../src/Controllers/HomePageController.php';
        $HomePageController = new HomePageController($pdo);
        $HomePageController->showHomePage();
        break;
    case 'profile':
        require_once __DIR__ . '/../src/Controllers/ProfileController.php';
        $ProfileController = new ProfileController($pdo);
        $ProfileController->showProfile();
        break;
    case 'student_profile':
        require_once __DIR__ . '/../src/Controllers/ProfileController.php';
        $ProfileController = new ProfileController($pdo);
        $ProfileController->showStudentProfile();
        break;
    case 'grades':
        require_once __DIR__ . '/../src/Controllers/ProfileController.php';
        $ProfileController = new ProfileController($pdo);
        $ProfileController->showGrades();
        break;
    case 'schedule':
        require_once __DIR__ . '/../src/Controllers/ProfileController.php';
        $ProfileController = new ProfileController($pdo);
        $ProfileController->showSchedule();
        break;
    case 'curriculum':
        require_once __DIR__ . '/../src/Controllers/CurriculumController.php';
        $CurriculumController = new CurriculumController($pdo);
        $CurriculumController->showCurriculum();
        break;
    case 'manage_section':
        require_once __DIR__ . '/../src/Controllers/RegistrationController.php';
        $RegistrationController = new RegistrationController($pdo);
        $RegistrationController->showManageSection();
        break;
    case 'erf':
        require_once __DIR__ . '/../src/Controllers/PaymentController.php';
        $ERFController = new PaymentController($pdo);
        $ERFController->showERF();
        break;
    case 'onlinepayment':
        require_once __DIR__ . '/../src/Controllers/PaymentController.php';
        $OnlinePaymentController = new PaymentController($pdo);
        $OnlinePaymentController->showOnlinePayment();
        break;
    case 'paymenthistory':
        require_once __DIR__ . '/../src/Controllers/PaymentController.php';
        $PaymentHistoryController = new PaymentController($pdo);
        $PaymentHistoryController->showPaymentHistory();
        break;
    case 'concerns':
        require_once __DIR__ . '/../src/Controllers/ConcernsController.php';
        $ConcernsController = new ConcernsController($pdo);
        $ConcernsController->showConcerns();
        break;
    default:
        require_once __DIR__ . '/../src/Controllers/AuthController.php';
        $LoginController = new AuthController($pdo);
        $LoginController->login();
        break;
}
?>