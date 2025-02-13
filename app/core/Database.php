<?php

namespace App\Core;

use PDO;

class Database
{
    private $connection;

    public function __construct()
    {
        $config = require_once __DIR__ . '/../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
