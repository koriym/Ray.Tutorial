<?php

namespace Todo9\Module;

use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    public function configure()
    {
        $this->install(new ConfigModule);
        $pdoSetter = $this->requestInjection('Todo9\Interceptor\PdoSetter');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('Todo9\Annotation\Db'),
            $this->matcher->any(),
            [$pdoSetter]
        );
    }
}
