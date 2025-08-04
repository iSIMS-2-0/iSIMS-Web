<?php

require_once __DIR__ . '/ConfigService.php';

class DatabaseService {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = ConfigService::getDatabaseConfig();
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $config['user'], $config['pass']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    // A Singleton Instance
    public static function getInstance(): DatabaseService {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
