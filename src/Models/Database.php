<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Connects to the database using PDO.
     *
     * This function establishes a connection to the database using the provided environment variables.
     * If a connection has already been established, it will return the existing connection.
     *
     * @throws PDOException If there is an error connecting to the database.
     *
     * @return PDO|null The database connection or null if a connection could not be established.
     */
    public static function connect(): ?PDO
    {
        if (self::$connection === null) {
            try {
                $host     = env('DB_HOST', '127.0.0.1');
                $dbname   = env('DB_NAME', 'giusoft');
                $username = env('DB_USERNAME', 'root');
                $password = env('DB_PASSWORD', '');

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
