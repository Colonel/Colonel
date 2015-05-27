<?php
/**
 * ...
 *
 * @author Nigel Greenway <nigel_greenway@me.com>
 * @license ...
 */

namespace Colonel\Test\Configuration;

use Colonel\Debugger;

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
        Debugger::composerLoad($start);

        $this->assertTrue(Debugger::getTimeTaken('composer') >= 1.000);
    }

    /**
     * @covers Colonel\Debugger::debugStart
     * @covers Colonel\Debugger::debugEnd
     * @covers Colonel\Debugger::getTimeTaken
     */
    public function test_debugging_of_section()
    {
        Debugger::debugStart('test');
        sleep(5);
        Debugger::debugEnd('test');

        $this->assertTrue(Debugger::getTimeTaken('test') >= 5.000);
    }
}
