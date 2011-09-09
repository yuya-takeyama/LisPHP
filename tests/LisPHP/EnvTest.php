<?php
/**
 * Test class for \LisPHP\Env.
 */

namespace LisPHP;

class EnvTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function offsetGet_should_be_the_value_it_contains()
    {
        $env = new Env;
        $env['foo'] = 'Some value';
        $this->assertSame('Some value', $env['foo']);
    }
}
