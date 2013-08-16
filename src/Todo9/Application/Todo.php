<?php

namespace Todo9\Application;

use PDO;
use Todo9\Annotation\Db;

/**
 * @Db
 */
class Todo implements TodoInterface
{
    public $pdo;

    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($todo)
    {
        $stmt = $this->pdo->prepare('INSERT INTO TODO (todo) VALUES (:todo)');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}