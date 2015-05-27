<?php

require __DIR__ . '/../../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$app = (new Colonel\HttpKernel(
    require __DIR__ . '/../Application/Configuration.dev.php'
))->run();