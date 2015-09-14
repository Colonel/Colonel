<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

/**
 * Interface for Service Provider
 * @package Colonel
 * @author  Nigel Greenway <nigel_greenway@me.com>
 */
interface ServiceProviderInterface
{
    /**
     * Run code before `HttpKernel#handle` dispatches the router
     * 
     * @param HttpKernel $httpKernel
     * 
     * @return void
     */
    public function boot(HttpKernel $httpKernel);

    /**
     * Run code after the response has been sent back to the client
     * 
     * @param HttpKernel $httpKernel
     * 
     * @return void
     */
    public function terminate(HttpKernel $httpKernel);
}