<?php
require_once __DIR__ . '/../src/Services/Router.php';

// Initialize router and register routes
$router = new Router();
$router->registerRoutes();

// Get the requested page
$page = $_GET['page'] ?? 'login';

// Dispatch the request
$router->dispatch($page);
?>