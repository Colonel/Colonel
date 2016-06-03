<?php
/** @license See LICENSE.md */
namespace Colonel;

use League\Route\Strategy\AbstractStrategy;
use League\Route\Strategy\StrategyInterface;

class UriRequestStrategy extends AbstractStrategy implements StrategyInterface
{
    /** {@inheritdoc} */
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
