<?php
/** @license See LICENSE.md */
namespace Colonel;

use \RuntimeException;

/** @author  Nigel Greenway <nigel_greenway@me.com> */
class ClassDoesNotImplementServiceProviderInterfaceException extends RuntimeException
{
    /** @param $className */
    public function __construct($className)
    {
        parent::__construct(
            sprintf(
                'The class [%s] does not implement the `%s`.',
                $className,
                ServiceProviderInterface::class
            )
        );
    }
}