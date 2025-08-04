<?php

class AuthService {
    private static $sessionStarted = false;

    public static function startSession(): void {
        if (!self::$sessionStarted && session_status() === PHP_SESSION_NONE) {
            session_start();
            self::$sessionStarted = true;
        }
    }

    public static function requireAuth(): void {
        self::startSession();
        if (!isset($_SESSION['student_number'])) {
            header("Location: /public/index.php?page=login");
            exit();
        }
    }

    public static function isLoggedIn(): bool {
        self::startSession();
        return isset($_SESSION['student_number']);
    }

    public static function getCurrentUser(): ?array {
        self::startSession();
        if (!self::isLoggedIn()) {
            return null;
        }

        return [
            'student_number' => $_SESSION['student_number'] ?? null,
            'student_id' => $_SESSION['student_id'] ?? null,
            'user_name' => $_SESSION['user_name'] ?? null,
            'last_activity' => $_SESSION['last_activity'] ?? null
        ];
    }

    public static function login(array $userData): void {
        self::startSession();
        $_SESSION['student_number'] = $userData['student_number'];
        $_SESSION['student_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['last_activity'] = time();
    }

    public static function logout(): void {
        self::startSession();
        session_unset();
        session_destroy();
    }

    public static function checkSessionTimeout(int $timeoutSeconds = 600): bool {
        self::startSession();
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeoutSeconds)) {
            self::logout();
            return true;
        }
        $_SESSION['last_activity'] = time();
        return false;
    }
}
