<?php
/**
 * Part of the Colonel Library
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license GNUv3
 */

namespace Colonel;

/**
 * A simple and unobtrusive way to profile sections of the application
 *
 * @package Colonel
 * @author Nigel Greenway <nigel_greenway@me.com>
 */
class Profiler
{
    /** @var array  */
    public static $container = [];

    /**
     * Add the composer timings to the debugging storage
     *
     * @param float $start
     */
    public static function composerLoad($start)
    {
        self::$container['composer']['start'] = $start;
        self::$container['composer']['end']   = sprintf('%0.3f', (microtime(true) - $start));
    }

    /**
     * Set the start of the timed process
     *
     * @param string $key The named section to debug
     */
    public static function start($key)
    {
        self::$container[$key]['start'] = microtime(true);
    }

    /**
     * Set the end of the timed process
     *
     * @param string $key The named section to debug
     */
    public static function end($key)
    {
        self::$container[$key]['end'] = sprintf('%0.3f', (microtime(true) - self::$container[$key]['start']));
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function getBreakdown($key)
    {
        return (float) self::$container[$key]['end'];
    }

    /**
     * Get the application runtime and memory usage
     *
     * @codeCoverageIgnore
     */
    public static function getRuntime()
    {
        return
            self::$container['HttpKernel']['end'] . ' [secs]' .
            ' | ' .
            sprintf('Total Memory: %.2f [mb]', (memory_get_usage(true) / 1024 / 1024));
    }
}