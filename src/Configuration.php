<?php
/** @license See LICENSE.md */
namespace Colonel;

use ArrayAccess;

/** @author  Nigel Greenway <nigel_greenway@me.com> */
class Configuration implements ArrayAccess
{
    /** @var array */
    private $container;

    /** @param array $configuration */
    public function __construct(array $configuration = [])
    {
        $this->container = $configuration;
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->container);
    }

    /**
     * @inheritDoc
     *
     * @throws ConfigurationKeyNotFoundException
     */
    public function offsetUnset($offset) {
        throw new ConfigurationKeyNotFoundException($offset);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function offsetGet($offset) {
        if (array_key_exists($offset, $this->container) === true) {
            return $this->container[$offset];
        }
    }
}