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
    public function invoke(MethodInvocation $invocation)
    {
        $pdo = new PDO('mysql:dbname=test;host=localhost');
        $invocation->getThis()->setPdo($pdo);

        return $invocation->proceed();
    }
}

class Module extends AbstractModule
{
    public function configure()
    {
        $this->bindInterceptor(
            $this->matcher->annotatedWith('Db'),
            $this->matcher->any(),
            [new PdoSetter]
        );
    }
}

$injector = Injector::create([new Module]);
$todo = $injector->getInstance('Todo');

$todo->add('Return book');