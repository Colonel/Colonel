<?php
/**
 * ...
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license ...
 */

namespace Demo\Application;

use Colonel\HttpKernel;
use Colonel\ServiceProviderInterface;

class DemoServiceProvider implements ServiceProviderInterface
{
    public function boot(HttpKernel $httpKernel)
    {
        echo '<p>Hello, from the service provider!</p>';
    }

    public function terminate(HttpKernel $httpKernel)
    {}
}