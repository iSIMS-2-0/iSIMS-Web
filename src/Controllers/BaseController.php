<?php

require_once __DIR__ . '/../Services/DatabaseService.php';
require_once __DIR__ . '/../Services/AuthService.php';

abstract class BaseController {
    protected $pdo;

    public function __construct() {
        $this->pdo = DatabaseService::getInstance()->getConnection();
    }

    protected function requireAuth(): void {
        AuthService::requireAuth();
    }

    protected function getCurrentUser(): ?array {
        return AuthService::getCurrentUser();
    }

    protected function renderView(string $viewPath, array $data = []): void {
        // Extract data to make variables available in the view
        extract($data);
        require $viewPath;
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit();
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getParam(string $key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    protected function getPostParam(string $key, $default = null) {
        return $_POST[$key] ?? $default;
    }
}
