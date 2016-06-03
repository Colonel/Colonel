<?php
/** @license See LICENSE.md */
namespace Colonel;

use League\Route\Http\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Container\Container;
use League\Route\RouteCollection;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

/** @author  Nigel Greenway <nigel_greenway@me.com> */
final class HttpKernel implements HttpKernelInterface, TerminableInterface
{
    /** @var Configuration */
    public $configuration;
    /** @var Container */
    public $container;
    /** @var RouteCollection */
    private $router;
    /** @var bool */
    private $booted    = false;
    /** @var bool */
    private $destroyed = false;

    /**
     * @param array $configuration
     *
     * @throws NoRouteStrategyDefinedException
     */
    public function __construct(
        array $configuration = []
    ) {
        $this->configuration = new Configuration($configuration);
        $this->container     = new Container($this->configuration['services']);
        $this->container->singleton(Configuration::class, $this->configuration);

        if (array_key_exists('route_strategy', $configuration) === false) {
            throw new NoRouteStrategyDefinedException;
        }

        $routeStrategy = $configuration['route_strategy'];
        $this->router  = new RouteCollection($this->container);
        $this->router->setStrategy(new $routeStrategy);

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

        $this->container->singleton(Request::class, $request);
        return $dispatcher->dispatch($request->getMethod(), $requestUri);
    }

    /**
     * {@inheritDoc}
     *
     * @throws ClassDoesNotImplementServiceProviderInterfaceException
     * @throws \Exception
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

    /** @return Container */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Call the boot method on a ServiceProvider
     *
     * @throws ClassDoesNotImplementServiceProviderInterfaceException
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