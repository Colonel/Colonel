<?php

return [
    'demo_page' => [
        'pattern'    => '/user/{name}',
        'controller' => 'Demo\src\Controller\DemoController::index',
        'method'     => 'GET',
    ],
];