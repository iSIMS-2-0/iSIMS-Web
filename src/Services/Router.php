<?php

require_once __DIR__ . '/../Services/DatabaseService.php';

class Router {
    private $routes = [];

    public function addRoute(string $route, string $controller, string $method): void {
        $this->routes[$route] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch(string $page): void {
        if (!isset($this->routes[$page])) {
            $page = 'login'; // Default route
        }

        $route = $this->routes[$page];
        $controllerClass = $route['controller'];
        $method = $route['method'];

        // Get database connection
        $pdo = DatabaseService::getInstance()->getConnection();

        // Require the controller file
        $controllerFile = __DIR__ . '/../Controllers/' . $controllerClass . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerClass($pdo);
            $controller->$method();
        } else {
            // Fallback to login
            require_once __DIR__ . '/../Controllers/AuthController.php';
            $controller = new AuthController($pdo);
            $controller->login();
        }
    }

    public function registerRoutes(): void {
        $this->addRoute('login', 'AuthController', 'login');
        $this->addRoute('home', 'HomePageController', 'showHomePage');
        $this->addRoute('profile', 'ProfileController', 'showProfile');
        $this->addRoute('student_profile', 'ProfileController', 'showStudentProfile');
        $this->addRoute('grades', 'ProfileController', 'showGrades');
        $this->addRoute('schedule', 'ProfileController', 'showSchedule');
        $this->addRoute('curriculum', 'CurriculumController', 'showCurriculum');
        $this->addRoute('manage_section', 'RegistrationController', 'showManageSection');
        $this->addRoute('erf', 'PaymentController', 'showERF');
        $this->addRoute('onlinepayment', 'PaymentController', 'showOnlinePayment');
        $this->addRoute('paymenthistory', 'PaymentController', 'showPaymentHistory');
        $this->addRoute('concerns', 'ConcernsController', 'showConcerns');
    }
}
