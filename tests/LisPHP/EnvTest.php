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

    /**
     * @test
     */
    public function find_should_the_env_itself_if_it_has_specified_variable()
    {
        $env = new Env;
        $env['foo'] = 'Some value';
        $this->assertSame($env, $env->find('foo'));
    }

    /**
     * @test
     */
    public function find_should_return_outer_env_has_specified_variable()
    {
        $outer = new Env;
        $outer['foo'] = 'Some value';

        $inner = new Env([], [], $outer);

        $this->assertSame($outer, $inner->find('foo'));
    }

    /**
     * @test
     */
    public function find_should_not_fail_if_it_has_no_outer_environment()
    {
        $inner = new Env;
        $this->assertNull($inner->find('foo'));
    }

    /**
     * @test
     */
    public function hasVariable_should_be_true_if_the_specified_variable_exists()
    {
        $env = new Env;
        $env['foo'] = 'foo';
        $this->assertTrue($env->hasVariable('foo'));
    }

    /**
     * @test
     */
    public function hasVariable_should_be_true_if_the_specified_variable_is_NULL()
    {
        $env = new Env;
        $env['foo'] = NULL;
        $this->assertTrue($env->hasVariable('foo'));
    }

    /**
     * @test
     */
    public function hasVariable_should_be_false_if_the_specified_variable_does_not_exist()
    {
        $env = new Env;
        $this->assertFalse($env->hasVariable('foo'));
    }
}
