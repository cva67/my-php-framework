<?php

namespace cva67\phpmvc\core;

use PDO;

class Migration
{

    private Database $database;
    private PDO $pdo;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->pdo = $this->database->getConnection();
    }

    public function applyMigration()
    {
        //$this->createInitialMigration();
        $migratedFiles = $this->getAppliedMigrations();

        $files = scandir(BASE_PATH . '/database/migrations');
        $newMigrations = array_diff($files, $migratedFiles);

        foreach ($newMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once BASE_PATH . '/database/migrations/' . $migration;
            $className =  'cva67\phpmvc\\database\\migrations\\' . pathinfo($migration, PATHINFO_FILENAME);
            $tableClass = new $className();
            $tableClass->up();
            $this->logMigration($migration);
        }
    }
    // public function createInitialMigration()
    // {

    //     $sql = "CREATE TABLE IF NOT EXISTS migrations (
    //         id INT AUTO_INCREMENT PRIMARY KEY,
    //         name VARCHAR(255) NOT NULL,
    //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    //     )";

    // try {
    //     $this->pdo->exec($sql);
    //     echo "Migrations table created successfully!";
    // } catch (\PDOException $e) {
    //     echo "Error creating migrations table: " . $e->getMessage();
    // }
    // }
    private function getAppliedMigrations(): array
    {
        $checkTableSql = "SHOW TABLES LIKE 'migrations'";
        $stmt = $this->pdo->query($checkTableSql);


        if ($stmt->rowCount() === 0) {
            return [];
        }
        $sql = "SELECT name FROM migrations";
        $stmt = $this->pdo->query($sql);

        $appliedMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $appliedMigrations;
    }

    private function logMigration($migration)
    {
        $sql = "INSERT INTO migrations (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $migration]);
    }

    public function applyRollback(string $table)
    {
        $checkTableSql = "SHOW TABLES LIKE '$table'";
        $stmt = $this->pdo->query($checkTableSql);

        if ($stmt->rowCount() === 0) {
            echo "$table not found";
            return;
        }
        $foundFile = null;
        $migratedFiles = $this->getAppliedMigrations();
        foreach ($migratedFiles as $file) {
            if (strpos($file, $table) !== false) {
                $foundFile = $file;
                break;
            }
        }
        $sql = "DELETE FROM migrations WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $foundFile]);
        require_once BASE_PATH . '/database/migrations/' . $foundFile;
        $className =  'cva67\phpmvc\\database\\migrations\\' . pathinfo($foundFile, PATHINFO_FILENAME);
        $tableClass = new $className();
        $tableClass->down();
    }
}
