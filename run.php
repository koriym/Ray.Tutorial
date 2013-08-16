<?php
/**
 * Run all example
 *
 * $ php run.php
 */
$list = [
    'todo1-hard-dependency.php',
    'todo2-manual-injection.php',
    'todo3-ray-di.php',
    'todo4-di-provider.php',
    'todo5-di-config.php',
    'todo6-aop.php',
    'todo7-aop-master-slave.php',
    'Todo9/main9.php',
    'Todo10/main10.php',
];

$result = 0;
foreach ($list as $php) {
    echo "$php: ";
    $file = __DIR__ . "/src/{$php}";
    passthru("php $file");
    echo PHP_EOL;
}
echo PHP_EOL . 'Complete' . PHP_EOL;
