<?php

namespace Todo9;

use Ray\Di\Injector;
use Todo10\Module\AppModule;

require __DIR__ . '/bootstrap.php';

$injector = Injector::create([new AppModule]);
$board = $injector->getInstance('Todo10\Application\Board');
/** @var $board \Todo10\Application\Board */
$board->addTodo('Try BEAR.Sunday');