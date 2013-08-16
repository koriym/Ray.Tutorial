<?php

namespace Todo9;

use Ray\Di\Injector;
use Todo9\Module\AppModule;

require __DIR__ . '/bootstrap.php';

$injector = Injector::create([new AppModule]);
$todo = $injector->getInstance('Todo9\Application\Todo');
/** @var $todo \Todo9\Application\Todo */
$todo->add('Shave the cat');