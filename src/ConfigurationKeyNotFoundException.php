<?php
/** @license See LICENSE.md */
namespace Colonel;

use Exception;

final class ConfigurationKeyNotFoundException extends Exception
{
    /** @param string $arrayKey */
    public function __construct($arrayKey)
    {
        parent::__construct(
            sprintf(
                'The required key [%s] does not exist in [%s]',
                $arrayKey,
                Configuration::class
            )
        );
    }
}