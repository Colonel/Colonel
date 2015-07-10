<?php

$default = [
    'Demo\\Application\\Adapter\\TwigAdapter' => [
        'class' => 'Demo\\Application\\Adapter\\TwigAdapter',
        'arguments' => [
            'Colonel\\Configuration',
        ],
    ],
];

return array_merge(
    $default,
    require __DIR__ . '/../src/Config/Service.php'
);