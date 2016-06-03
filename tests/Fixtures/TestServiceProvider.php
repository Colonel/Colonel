<?php
/** @license See LICENSE.md */
namespace Colonel\Test\Fixtures;

use Colonel\HttpKernel;
use Colonel\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class TestServiceProvider implements ServiceProviderInterface
{
    public function boot(HttpKernel $httpKernel)
    {
        $httpKernel->container->offsetSet(
            'server',
            $httpKernel->container->get(Request::class)->server
        );
    }

    public function terminate(HttpKernel $httpKernel)
    {}
}