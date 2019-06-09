<?php

use BookLibrary\Application;

spl_autoload_register(function(string $class) {
    $prefix = 'BookLibrary\\';

    $relativeClass = substr($class, strlen($prefix));

    $file = __DIR__ . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';

    require_once $file;
});

$app = new Application(
    [
        __DIR__ . '/input/2017-01.xml',
        __DIR__ . '/input/2017-02.csv'
    ]
);

try {
    $app
        ->run()
        ->report(__DIR__ . '/output/report.json')
        ->report(__DIR__ . '/output/report.txt');
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}
