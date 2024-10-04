<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * @throws PDOException
     */
    public static function connect(): ?PDO
    {
        if (self::$connection === null) {
            try {
                $host     = getenv('DB_HOST') ?: '127.0.0.1';
                $dbname   = getenv('DB_NAME') ?: 'giusoft';
                $username = getenv('DB_USERNAME') ?: 'root';
                $password = getenv('DB_PASSWORD') ?: '';

                self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
            } catch (PDOException $e) {
                throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
