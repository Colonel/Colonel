<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

use Exception;

final class NoRouteStrategyDefinedException extends Exception
{
    public function __construct()
    {
        return parent::__construct("There is no route strategy defined in the configuration file\nPlease add the FQCN to the `route_strategy` index in the root of the configuration file.");
    }
}