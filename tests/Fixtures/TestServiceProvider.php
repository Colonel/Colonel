<?php
/** @license See LICENSE.md */
namespace Colonel\Test\Fixtures;

use Colonel\HttpKernel;
use Colonel\ServiceProviderInterface;

class TestServiceProvider implements ServiceProviderInterface
{
    public function boot(HttpKernel $httpKernel)
    {
        $httpKernel->container->singleton(\stdClass::class, new \stdClass());
    }

    public function terminate(HttpKernel $httpKernel)
    {}
}