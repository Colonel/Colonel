# Colonel

To use, simply add:

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$app = (new Colonel\HttpKernel(
    require_once __DIR__ . '/../Application/Configuration.php'
))->run();
```

An example configuration file:

```php
<?php

return [
    'debug'  => false,
    'routes' => [
        'DemoBundle' => [
            'hello_world' => [
                'pattern'    => '/your/pattern/{var}',
                'controller' => 'Path\\To\\Class::method',
                'method'     => 'GET',
            ],
        ],
    ],
    'services' => [
        'di' => [
            'Path\\To\\Some\\Dependency' => [
                'class' => 'Path\\To\\Some\\Dependency',
                'arguments' => [
                    'Path\\To\\Some\\Other\\Dependency',
                ],
            ],
            'Path\\To\\Some\\Other\\Dependency' => [
                'class' => 'Path\\To\\Some\\Other\\Dependency',
            ],
        ],
    ],
];
```

> This will be fleshed more out soon...