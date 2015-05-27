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
 * Class UriRequestStrategy
 * @package League\Route\Strategy
 */
class UriRequestStrategy extends AbstractStrategy implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function dispatch($controller, array $vars)
    {
         $response = $this->invokeController(
            $controller,
            array_merge(
                $vars,
                [
                    'request' => $this->getContainer()->get('Symfony\Component\HttpFoundation\Request')
                ]
            )
        );

        return $this->determineResponse($response);
    }
}
