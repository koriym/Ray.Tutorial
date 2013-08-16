<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Di\AbstractModule;
use Ray\Di\Di\Scope;
use Ray\Di\Injector;
use Ray\Di\ProviderInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;


$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

class Todo
{
    /**
     * @var Ray\Di\ProviderInterface
     */
    private $pdo;

    /**
     * @Inject
     * @Named("pdo")
     */
    public function __construct(ProviderInterface $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $todo
     */
    public function add($todo)
    {
        $stmt = $this->pdo->get()->prepare('INSERT INTO TODO (todo) VALUES (:todo)');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}

class PdoFactory implements ProviderInterface
{
    public function get()
    {
        return new PDO('mysql:dbname=test;host=localhost');
    }
}

class Module extends AbstractModule
{
    public function configure()
    {
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('pdo')->to('PdoFactory')->in(Scope::SINGLETON);
    }
}

$injector = Injector::create([new Module], new \Doctrine\Common\Cache\FilesystemCache('/tmp/ray'));
$todo = $injector->getInstance('Todo');
/** @var $todo Todo */
$todo->add('But groceries');