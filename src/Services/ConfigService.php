<?php

class ConfigService {
    private static $config = null;

    public static function get(string $key = null) {
        if (self::$config === null) {
            self::$config = require __DIR__ . '/../../config.php';
        }

        if ($key === null) {
            return self::$config;
        }

        return self::$config[$key] ?? null;
    }

    public static function getDatabaseConfig(): array {
        return [
            'host' => self::get('host'),
            'db' => self::get('db'),
            'user' => self::get('user'),
            'pass' => self::get('pass')
        ];
    }
}
