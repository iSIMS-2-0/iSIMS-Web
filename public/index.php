<?php
require_once __DIR__ . '/../config.php';

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
        require __DIR__ . '/../src/Views/Payment/erf.php';
        break;
    default:
        require_once __DIR__ . '/../src/Controllers/AuthController.php';
        $LoginController = new AuthController($pdo);
        $LoginController->login();
        break;
}
?>