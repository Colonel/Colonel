<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

use ArrayAccess;

/**
 * Configuration store
 *
 * @package Colonel
 * @author  Nigel Greenway <nigel_greenway@me.com>
 */
class Configuration implements ArrayAccess
{
    /** @var array */
    private $container;

    /**
     * Class Constructor
     *
     * @param array $configuration
     */
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
        if (is_null($offset)) {
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
        return isset($this->container[$offset]);
    }

    /** {@inheritDoc} */
    public function offsetUnset($offset) {
        throw new ConfigurationKeyNotFoundException($offset);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function offsetGet($offset) {
        if (isset($this->container[$offset])) {
            return $this->container[$offset];
        }
    }
}