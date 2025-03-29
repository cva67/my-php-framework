<?php

namespace cva67\phpmvc;

use cva67\phpmvc\config\config;
use PDO;
use PDOException;

class Database
{
    protected PDO $pdo;

    public function __construct()
    {
        $host = config::get('database', 'host');
        $port = config::get('database', 'port');
        $name = config::get('database', 'name');
        $charset = config::get('database', 'charset');
        $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=$charset";
        $user = config::get('database', 'username');
        $password = config::get('database', 'password');

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
