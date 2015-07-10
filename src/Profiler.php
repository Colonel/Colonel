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
     * Set the start of the timed process
     *
     * @param string $key The named section to debug
     */
    public static function start($key)
    {
        self::$container[$key]['start'] = microtime(true);
    }

    /**
     * Set the finish of the timed process
     *
     * @param string $key The named section to debug
     */
    public static function finish($key)
    {
        self::$container[$key]['end'] = microtime(true) - self::$container[$key]['start'];
    }

    /**
     * Get the application runtime and memory usage
     *
     * @codeCoverageIgnore
     */
    public static function getRuntime()
    {
        foreach(self::$container as $key => $data) {
            if (isset($data['end']) === false) {
                self::$container[$key]['end'] = microtime(true) - self::$container[$key]['start'];
            }
        }

        return [
            'runtime' => self::$container['http.kernel']['end'],
            'memory_usage'  => (memory_get_usage(true) / 1024 / 1024),
            'breakdown' => self::$container,
        ];
    }
}