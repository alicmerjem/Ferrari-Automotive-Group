<?php
// Set error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Config {
    public static function DB_HOST() {
        return 'localhost';
    }

    public static function DB_NAME() {
        return 'ferrari_automotive_group';
    }

    public static function DB_USER() {
        return 'root';
    }

    public static function DB_PASSWORD() {
        return '';
    }

    public static function DB_PORT() {
        return 3306;
    }

    public static function JWT_SECRET() {
        return 'Ec2FISbLxDeIe9GrpuhjC03yzPvjRWvM';
    }
}

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . ";port=" . Config::DB_PORT(),
                    Config::DB_USER(),
                    Config::DB_PASSWORD(),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>
