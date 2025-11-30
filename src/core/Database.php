<?php
namespace Core;

class Database {
    private static $instance = null;
    public $connection;

    private function __construct() {
        // مسیر جدید فایل config دیتابیس
        $dbConfig = require __DIR__ . '/dbconfig.php';

        $host = $dbConfig['host'];
        $user = $dbConfig['username'];
        $pass = $dbConfig['password'];
        $dbname = $dbConfig['database'];
        $port = $dbConfig['port'] ?? 3306;

        $this->connection = new \mysqli($host, $user, $pass, $dbname, $port);
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }

        $this->connection->set_charset($dbConfig['charset'] ?? 'utf8mb4');
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
