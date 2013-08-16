<?php

namespace Todo9\Module;

use Ray\Di\AbstractModule;

class ConfigModule extends AbstractModule
{
    public function configure()
    {
        $config = require dirname(__DIR__) . '/config/app.php';
        $this->bind('')->annotatedWith('config')->toInstance($config);
    }
}