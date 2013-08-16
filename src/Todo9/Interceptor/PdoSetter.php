<?php

namespace Todo9\Interceptor;

use PDO;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class PdoSetter implements MethodInterceptor
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @Inject
     * @Named("config")
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        if ($invocation->getMethod()->name === 'add') {
            $dsn = $this->config['db']['slave'];
        } else {
            $dsn = $this->config['db']['master'];
        }
        $pdo = new PDO($dsn);
        $invocation->getThis()->setPdo($pdo);

        return $invocation->proceed();
    }
}