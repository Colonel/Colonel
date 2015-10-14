<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

use \RuntimeException;

/**
 * Exception for when a class does not implement ServiceProviderInterface as expected
 * 
 * @package Colonel
 * @author  Nigel Greenway <nigel_greenway@me.com>
 */
class ClassDoesNotImplementServiceProviderInterfaceException extends RuntimeException
{
    /**
     * @param $className
     * 
     * @return ClassDoesNotImplementServiceProviderInterfaceException
     */
    public function __construct($className)
    {
        return parent::__construct(
            sprintf(
                'The class [%s] does not implement the `ServiceProviderInterface`.',
                $className
            )
        );
    }
}