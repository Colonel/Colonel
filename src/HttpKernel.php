<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

use League\Route\Http\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Container\Container;
use League\Route\RouteCollection;
use League\Route\Http\Exception\NotFoundException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

/**
 * The HTTP Kernel
 *
 * @package Colonel
 * @author  Nigel Greenway <nigel_greenway@me.com>
 */
final class HttpKernel implements HttpKernelInterface, TerminableInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * Class Constructor
     *
     * @param array $configuration
     */
    public function __construct(
        array $configuration = []
    ) {
        $this->configuration = new Configuration($configuration);
        $this->configuration['debug'] === true ?
            Profiler::start('HttpKernel') :
            ''
        ;

        $this->container     = new Container($this->configuration['services']);
        $this->container->singleton('config', $this->configuration);

        $this->router = new RouteCollection($this->container);
        $this->router->setStrategy(new UriRequestStrategy);

        foreach($this->configuration['routes'] as $collection) {
            foreach($collection as $route) {
                $this->router->addRoute(
                    $route['method'],
                    $route['pattern'],
                    $route['controller']
                );
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $dispatcher = $this->router->getDispatcher();

        try {
            $response = $dispatcher->dispatch($request->getMethod(), $request->getRequestUri());

            $this->configuration['debug'] === true ?
                $response->setContent(
                    $response->getContent() .
                    Profiler::end('HttpKernel') .
                    Profiler::getRuntime()
                ) :
                ''
            ;

        } catch (NotFoundException $exception) {
            $response = Response::create(
                sprintf(
                    '<h1>Oops, there is an error: <strong>%s</strong></h1><p>Does the requested route `<strong>%s</strong>` exist?</p><pre>%s</pre>',
                    $exception->getMessage(),
                    $request->getRequestUri(),
                    $exception->getTraceAsString()
                ),
                Response::HTTP_NOT_FOUND
            );
        }

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function run(Request $request = null)
    {
        if ($request === null) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);
        $response->send();

        $this->terminate($request, $response);
    }

    /**
     * {@inheritDoc}
     */
    public function terminate(Request $request, Response $response)
    {}
}