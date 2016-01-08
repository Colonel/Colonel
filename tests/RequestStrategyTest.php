<?php

namespace Colonel\Test\Configuration;

use Colonel\HttpKernel;
use Colonel\UriArrayRequestStrategy;
use Colonel\UriRequestStrategy;
use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteStrategyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers UriArrayRequestStrategy::__construct
     */
    public function test_UriArrayRequestStrategy_displays_correct_data()
    {
        $_SERVER['REQUEST_URI'] = '/users/scooby/address/mystery-van';
        $app = new HttpKernel([
            'debug' => false,
            'services' => [
                'di' => [
                    // Leave empty
                ],
            ],
            'route_strategy' => UriArrayRequestStrategy::class,
            'routes' => [
                'test_group' => [
                    'test_route' => [
                        'pattern'    => '/users/{name}/address/{address}',
                        'controller' => function($args) {
                            return Response::create(json_encode($args), 200);
                        },
                        'method'     => 'GET',
                    ],
                ],
            ],
        ]);

        $request = Request::createFromGlobals();

        $response = $app->handle($request);

        $this->assertEquals('{"name":"scooby","address":"mystery-van"}', $response->getContent());
    }
    /**
     * @covers UriRequestStrategy::__construct
     */
    public function test_UriRequestStrategy_displays_correct_data()
    {
        $_SERVER['REQUEST_URI'] = '/users/scooby/address/mystery-van';
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
                        'pattern'    => '/users/{name}/address/{address}',
                        'controller' => function($name, $address) {
                            return Response::create(json_encode([$name, $address]), 200);
                        },
                        'method'     => 'GET',
                    ],
                ],
            ],
        ]);

        $request = Request::createFromGlobals();

        $response = $app->handle($request);

        $this->assertEquals('["scooby","mystery-van"]', $response->getContent());
    }

    public function tearDown()
    {
        $_SERVER['REQUEST_URI'] = null;
    }
}
