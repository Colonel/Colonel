<?php
/** @license See LICENSE.md */
namespace Colonel;

use Exception;

final class NoRouteStrategyDefinedException extends Exception
{
    public function __construct()
    {
        $message = <<<MSG
There is no route strategy defined in the configuration file
Please add the FQCN to the `route_strategy` index in the root of the configuration file.
MSG;
        parent::__construct($message);
    }
}