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
    public $configuration;

    /**
     * @var Container
     */
    public $container;

    /**
     * @var bool
     */
    private $booted    = false;

    /**
     * @var bool
     */
    private $destroyed = false;

    /**
     * Class Constructor
     *
     * @param array $configuration
     */
    public function __construct(
        array $configuration = []
    ) {
        $this->configuration = new Configuration($configuration);
        $this->container     = new Container($this->configuration['services']);
        $this->container->singleton(Configuration::class, $this->configuration);

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
        $requestUri = parse_url($request->getRequestUri(), PHP_URL_PATH);

        try {
            $this->container->singleton(Request::class, $request);
            $response = $dispatcher->dispatch($request->getMethod(), $requestUri);


        } catch (NotFoundException $exception) {
            $response = Response::create(
                sprintf(
                    '<h1>Oops, there is an error: <strong>%s</strong></h1><p>Does the requested route `<strong>%s</strong>` exist?</p><pre>%s</pre>',
                    $exception->getMessage(),
                    $requestUri,
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
        $this->boot();

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
    {
        if (
            $this->destroyed === false
            && $this->configuration['service_providers'] !== null
        ) {
            foreach($this->configuration['service_providers'] as $provider) {
                $provider->terminate($this);
            }
        }
    }

    /**
     * Get the container
     * 
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Call the boot method on a ServiceProvider
     * 
     * @return void
     */
    private function boot()
    {
        if (
            $this->booted === false
            && $this->configuration['service_providers'] !== null
        ) {
            foreach ($this->configuration['service_providers'] as $provider) {
                if ($provider instanceof ServiceProviderInterface === false) {
                    throw new ClassDoesNotImplementServiceProviderInterfaceException(get_class($provider));
                }
                $provider->boot($this);
            }
        }

        $this->booted = true;
    }
}