<?php

namespace Todo9;

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->set('Todo9', dirname(__DIR__));
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
