<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

class Todo
{
    private $pdo;

    /**
     * @Inject
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $todo
     */
    public function add($todo)
    {
        $stmt = $this->pdo->prepare('INSERT INTO TODO (todo) VALUES (:todo)');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}

class Module extends AbstractModule
{
    public function configure()
    {
        $pdo = new PDO('mysql:dbname=test;host=localhost');
        $this->bind('PDO')->toInstance($pdo);
    }
}

$injector = Injector::create([new Module]);
$todo = $injector->getInstance('Todo');
/** @var $todo Todo */
$todo->add('Walking in Ray');