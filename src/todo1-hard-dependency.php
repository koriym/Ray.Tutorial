<?php

class Todo
{
    /**
     * @param $todo
     */
    public function add($todo)
    {
        $pdo = new PDO('mysql:dbname=test;host=localhost');
        $stmt = $pdo->prepare('INSERT INTO TODO (todo) VALUES (:todo)');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}

$todo = new Todo;
$todo->add('Pay bills');