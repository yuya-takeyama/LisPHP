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
    public function evaluate_should_return_the_value_of_variable_if_the_argument_is_string_as_a_symbol()
    {
        $env = new Env;
        $env['symbol'] = 'Some value';
        $this->assertSame('Some value', $this->lisphp->evaluate(':symbol', $env));
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

    /**
     * @test
     */
    public function evaluate_quote_function_should_return_rest_of_the_S_expression_as_array()
    {
        $this->assertSame(
            [1, 2, 3],
            $this->lisphp->evaluate(['quote', 1, 2, 3])
        );
    }

    /**
     * @test
     */
    public function evaluate_if_function_should_return_former_expression_if_the_test_is_true()
    {
        $this->assertSame(
            'Former',
            $this->lisphp->evaluate(['if', true, 'Former', 'Latter'])
        );
    }

    /**
     * @test
     */
    public function evaluate_if_function_should_return_latter_expression_if_the_test_is_false()
    {
        $this->assertSame(
            'Latter',
            $this->lisphp->evaluate(['if', false, 'Former', 'Latter'])
        );
    }

    /**
     * @test
     */
    public function evaluate_execute_user_defined_function_addition()
    {
        $env = new Env;
        $env['+'] = function ($x, $y) { return $x + $y; };
        $this->assertSame(3, $this->lisphp->evaluate(['+', 1, 2], $env));
    }

    /**
     * @test
     */
    public function evaluate_execute_user_defined_function_substaction()
    {
        $env = new Env;
        $env['-'] = function ($x, $y) { return $x - $y; };
        $this->assertSame(1, $this->lisphp->evaluate(['-', 3, 2], $env));
    }

    /**
     * @test
     */
    public function evaluate_execute_user_defined_function_multiplication()
    {
        $env = new Env;
        $env['*'] = function ($x, $y) { return $x * $y; };
        $this->assertSame(6, $this->lisphp->evaluate(['*', 2, 3], $env));
    }

    /**
     * @test
     */
    public function evaluate_execute_user_defined_function_division()
    {
        $env = new Env;
        $env['/'] = function ($x, $y) { return $x / $y; };
        $this->assertSame(5, $this->lisphp->evaluate(['/', 10, 2], $env));
    }
}
