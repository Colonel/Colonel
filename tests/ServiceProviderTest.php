<?php
/** @license See LICENSE.md */
namespace Colonel\Test\Configuration;

use Colonel\HttpKernel;
use Colonel\Test\Fixtures\TestServiceProvider;
use Colonel\UriRequestStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @covers \Colonel\HttpKernel::run */
    public function test_handle_is_successful_with_a_service_provider()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $app = new HttpKernel([
            'debug' => false,
            'services' => [
                'di' => [
                    // Leave empty
                ],
            ],
            'route_strategy' => UriRequestStrategy::class,
            'routes' => [
                'test_group' => [
                    'test_route' => [
                        'pattern'    => '/',
                        'controller' => function() {
                            // Some functionality...
                        },
                        'method'     => 'GET',
                    ],
                ],
            ],
            'service_providers' => [
                TestServiceProvider::class => new TestServiceProvider()
            ],
        ]);

        $app->run(Request::createFromGlobals());

        $this->assertTrue($app->container->isSingleton(\stdClass::class, new \stdClass()));
    }

    /**
     * @covers \Colonel\HttpKernel::handle
     * @covers \Colonel\HttpKernel::run
     */
    public function test_handle_is_successful_without_a_service_provider()
    {
        $app = new HttpKernel([
            'debug' => false,
            'services' => [
                'di' => [
                    // Leave empty
                ],
            ],
            'route_strategy' => UriRequestStrategy::class,
            'routes' => [
                'test_group' => [
                    'test_route' => [
                        'pattern'    => '/',
                        'controller' => function() {
                            return Response::create('<h1>Hello World</h1>', 200);
                        },
                        'method'     => 'GET',
                    ],
                ],
            ],
            'service_providers' => [
            ],
        ]);

        $_SERVER['REQUEST_URI'] = '/';

        $response = $app->handle(
            Request::createFromGlobals(),
            HttpKernel::MASTER_REQUEST
        );

        $this->assertEquals('<h1>Hello World</h1>', $response->getContent());
    }
}
