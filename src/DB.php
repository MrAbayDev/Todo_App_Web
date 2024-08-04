<?php
declare(strict_types=1);

namespace Abdulqayum\TodoApp;

use PDO;
use Dotenv\Dotenv;

class DB
{
    public static function connect(): PDO
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $dsn = "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        return new PDO($dsn, $username, $password);
    }
}
