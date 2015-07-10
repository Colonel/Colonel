<?php
/**
 * ...
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license ...
 */

namespace Colonel\Test\Configuration;

use Colonel\Profiler;

class DebuggerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Colonel\Debugger::debugStart
     * @covers Colonel\Debugger::debugEnd
     * @covers Colonel\Debugger::getTimeTaken
     */
    public function test_debugging_of_section()
    {
        Profiler::start('http.kernel');
        Profiler::start('test');
        sleep(5);
        Profiler::finish('test');
        Profiler::finish('http.kernel');

        $this->assertArrayHasKey('runtime', Profiler::getRuntime());
        $this->assertArrayHasKey('memory_usage', Profiler::getRuntime());
        $this->assertArrayHasKey('http.kernel', Profiler::getRuntime()['breakdown']);
        $this->assertArrayHasKey('test', Profiler::getRuntime()['breakdown']);
    }
}
