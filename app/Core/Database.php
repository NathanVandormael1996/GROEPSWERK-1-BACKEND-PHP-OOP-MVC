<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $configPath = dirname(__DIR__) . '/config/database.php';

            if (!file_exists($configPath)) {
                $rootConfig = dirname(__DIR__, 2) . '/config/database.php';
                if (file_exists($rootConfig)) {
                    $configPath = $rootConfig;
                } else {
                    die("Kan config niet vinden op: " . $configPath);
                }
            }

            $config = require $configPath;

            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

                self::$connection = new PDO($dsn, $config['user'], $config['pass'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die("Database verbinding mislukt: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}