<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

use Exception;

final class ConfigurationKeyNotFoundException extends Exception
{
    public function __construct($arrayKey)
    {
        return parent::__construct(
            sprintf(
                'The required key [%s] does not exist in [%s]',
                $arrayKey,
                'calling class'
            )
        );
    }
}