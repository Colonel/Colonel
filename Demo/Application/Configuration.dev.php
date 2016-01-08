<?php

$debug = true;

return [
    'debug'  => $debug,
    'kernel' => [
        'root' => realpath(__DIR__),
    ],
    'databases' => [
        'write' => [
            'driver'   => 'mysql',
            'host'     => '127.0.0.1',
            'name'     => 'simple_x',
            'user'     => 'root',
            'password' => null,
        ],
    ],
    'twig' => [
        'paths' => [
            'Base'    => '/View',
            'Welcome' => '/../src/View',
        ],
        'options' => [
            'debug' => false,
            'cache' => realpath(__DIR__.'/../var/Cache/Twig'),
            'strict_variables' => $debug,
            'auto_reload' => true,
            'autoescape' => true,
        ],
    ],
    'routes' => [
        'DemoBundle' => require realpath(__DIR__ . '/../src/Routing/Routing.php'),
    ],
    'route_strategy' => \Colonel\UriRequestStrategy::class,
    'services' => [
        'di' => require realpath(__DIR__ . '/Service.php'),
    ],
    'service_providers' => [
        \Demo\Application\DemoServiceProvider::class => new \Demo\Application\DemoServiceProvider(),
    ]
];