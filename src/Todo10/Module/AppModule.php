<?php

namespace Todo10\Module;

use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    public function configure()
    {
        $this->install(new \Todo9\Module\AppModule);
        $this->bind('\Ray\Aop\Weave')->annotatedWith('todo')->to('Todo9\Application\Todo');
    }
}
