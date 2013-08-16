<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

/**
 * @Db
 */
class Todo
{
    private $pdo;

    public function setPdo(Pdo $pdo)
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

/**
 * @Annotation
 */
class Db
{
}

class PdoSetter implements MethodInterceptor
{
    private $config = [];

    /**
     * @Inject
     * @Named("config")
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function invoke(MethodInvocation $invocation)
    {
        if ($invocation->getMethod()->name === 'add') {
            $dsn = $this->config['slave'];
        } else {
            $dsn = $this->config['master'];
        }
        $pdo = new PDO($dsn);
        $invocation->getThis()->setPdo($pdo);

        return $invocation->proceed();
    }
}

class Config extends AbstractModule
{
    public $config = [
        'master' => 'mysql:dbname=test;host=localhost',
        'slave' => 'mysql:dbname=test;host=localhost'
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
        $this->install(new Config);
        $pdoSetter = $this->requestInjection('PdoSetter');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('Db'),
            $this->matcher->any(),
            [$pdoSetter]
        );
    }
}

$injector = Injector::create([new Module]);
$todo = $injector->getInstance('Todo');

$todo->add('Take a picture');