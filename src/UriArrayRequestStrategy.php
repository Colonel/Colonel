<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

use League\Route\Strategy\AbstractStrategy;
use League\Route\Strategy\StrategyInterface;

/**
 * Invoke a controller with an array of URI parameters and the Request object
 *
 * @package League\Route\Strategy
 */
class UriArrayRequestStrategy extends AbstractStrategy implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function dispatch($controller, array $vars)
    {
         $response = $this->invokeController(
            $controller,
            [
                $vars,
                'request' => $this->getContainer()->get('Symfony\Component\HttpFoundation\Request')
            ]
        );

        return $this->determineResponse($response);
    }
}
