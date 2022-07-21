<?php

namespace App\Entity;

use Exception;
use PDO;
use PDOException;

class Database
{
    private $connection;

    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                'mysql:host=' . getenv('DB_HOST') .
                ';port=3306;dbname=' . getenv('DB_NAME'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD'));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                $this->connection->query("SELECT 1 FROM user LIMIT 1");
            } catch (Exception $e) {
                $this->initSchema($this->connection);
            }
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }

        return $this->connection;
    }

    private function initSchema(PDO $conn)
    {
        $queryTodo = 'CREATE TABLE todo (id int NOT NULL AUTO_INCREMENT, description varchar(255) NOT NULL, is_complete boolean DEFAULT FALSE, user varchar(255) NOT NULL, PRIMARY KEY (id))';
        $queryUser = 'CREATE TABLE user (id int NOT NULL AUTO_INCREMENT, login varchar(255) NOT NULL, password varchar(255) NOT NULL, PRIMARY KEY (id))';
        $todoStmt = $conn->prepare($queryTodo);
        $userStmt = $conn->prepare($queryUser);
        $todoStmt->execute();
        $userStmt->execute();
    }
}
