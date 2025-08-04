<?php
require_once __DIR__ . '/../Services/AuthService.php';

class ConcernsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showConcerns() {
        AuthService::requireAuth();
        require __DIR__ . '/../Views/ConcernsFeedback/concernsFeedback.php';
    }
}
?>