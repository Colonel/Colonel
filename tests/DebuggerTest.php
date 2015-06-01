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
     * @covers Colonel\Debugger::composerLoad
     * @covers Colonel\Debugger::getTimeTaken
     */
    public function test_composer_loadtime()
    {
        $start = microtime(true);
        sleep(1);
        Profiler::composerLoad($start);

        $this->assertTrue(Profiler::getBreakdown('composer') >= 1.000);
    }

    /**
     * @covers Colonel\Debugger::debugStart
     * @covers Colonel\Debugger::debugEnd
     * @covers Colonel\Debugger::getTimeTaken
     */
    public function test_debugging_of_section()
    {
        Profiler::start('test');
        sleep(5);
        Profiler::end('test');

        $this->assertTrue(Profiler::getBreakdown('test') >= 5.000);
    }
}
