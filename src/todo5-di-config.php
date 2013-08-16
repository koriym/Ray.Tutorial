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
    private $pdo;

    /**
     * @Inject
     * @Named("pdo")
     */
    public function setPdo(ProviderInterface $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($todo)
    {
        $stmt = $this->pdo->get()->prepare('INSERT INTO TODO (todo) VALUES (:todo)');
        $stmt->bindParam(':todo', $todo);
        $stmt->execute();
    }
}


class PdoFactory implements ProviderInterface
{
    /**
     * @var string
     */
    private $dsn;

    /**
     * @param array $config
     *
     * @Inject
     * @Named("config");
     */
    public function setDsn(array $config)
    {
        $this->dsn = $config['dsn'];
    }

    public function get()
    {
        return new PDO($this->dsn);
    }
}

class Config extends AbstractModule
{
    public $config = [
        'dsn' => 'mysql:dbname=test;host=localhost'
    ];

    public function configure()
    {
        $this->bind('')->annotatedWith('config')->toInstance($this->config);
    }
}

class Module extends AbstractModule
{
    public function configure()
    {
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('pdo')->to('PdoFactory')->in(Scope::SINGLETON);
    }
}

$injector = Injector::create([new Config, new Module]);
$todo = $injector->getInstance('Todo');

$todo->add('Call mom');