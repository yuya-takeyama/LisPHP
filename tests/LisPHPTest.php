<?php
/**
 * Test class for LisPHP.
 */

use LisPHP\Env;

class LisPHPTest extends PHPUnit_Framework_TestCase
{
    protected $lisphp;

    public function setUp()
    {
        $this->lisphp = new LisPHP;
    }

    /**
     * @test
     */
    public function evaluate_should_be_the_number_if_the_argument_is_a_number()
    {
        $this->assertSame(1, $this->lisphp->evaluate(1));
    }

    /**
     * @test
     */
    public function evaluate_should_be_the_string_if_the_argument_is_a_normal_string()
    {
        $this->assertSame("Normal string", $this->lisphp->evaluate('Normal string'));
    }

    /**
     * @test
     */
    public function evaluate_defiine_function_should_define_a_variable_into_the_env()
    {
        $env = new Env;
        $lisphp = new LisPHP;
        $lisphp->evaluate(['define', 'foo', 'Some value'], $env);

        $this->assertSame('Some value', $env['foo']);
    }
}
