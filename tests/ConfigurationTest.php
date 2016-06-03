<?php
/** @license See LICENSE.md */
namespace Colonel\Test\Configuration;

use Colonel\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /** @covers Colonel\Configuration::__construct */
    public function test_debug_is_not_enabled_by_default()
    {
        $configuration = new Configuration([
            'debug'     => false,
        ]);

        $this->assertFalse($configuration['debug']);
    }

    /** @covers Colonel\Configuration::__construct */
    public function test_debug_is_enabled_by_default()
    {
        $configuration = new Configuration([
            'debug'     => true,
        ]);

        $this->assertTrue($configuration['debug']);
    }

    /** @covers Colonel\Configuration::__construct */
    public function test_key_returns_an_array()
    {
        $configuration = new Configuration([
            'databases' => [
                'host'     => 'test.host',
                'user'     => 'root',
                'password' => 'easy_password',
                'dbname'   => 'my_db',
            ],
        ]);

        $this->assertTrue(gettype($configuration['databases']) == 'array');
    }

    /** @covers Colonel\Configuration::__construct */
    public function test_key_return_correct_array_keys()
    {
        $configuration = new Configuration([
            'databases' => [
                'host'     => 'test.host',
                'user'     => 'root',
                'password' => 'easy_password',
                'dbname'   => 'my_db',
            ],
        ]);

        $this->assertArrayHasKey('host', $configuration['databases']);
        $this->assertArrayHasKey('user', $configuration['databases']);
        $this->assertArrayHasKey('password', $configuration['databases']);
        $this->assertArrayHasKey('dbname', $configuration['databases']);
    }

    /**
     * @expectedException \Colonel\ConfigurationKeyNotFoundException
     *
     * @covers Colonel\Configuration::__construct
     * @covers Colonel\Configuration::offsetUnset
     */
    public function test_key_has_been_removed()
    {
        $configuration = new Configuration([
            'remove_me' => 'NOW!',
        ]);
        $configuration->offsetUnset('remove_me');
    }
}
