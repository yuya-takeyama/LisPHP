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
    public function evaluate_equal_true()
    {
        $this->assertTrue($this->lisphp->evaluate(['=', 1, 1]));
    }

    /**
     * @test
     */
    public function evaluate_equal_false()
    {
        $this->assertFalse($this->lisphp->evaluate(['=', 1, 2]));
        $this->assertFalse($this->lisphp->evaluate(['=', 1, '1']));
    }

    /**
     * @test
     */
    public function evaluate_addition()
    {
        $this->assertSame(3, $this->lisphp->evaluate(['+', 1, 2]));
    }

    /**
     * @test
     */
    public function evaluate_subtraction()
    {
        $this->assertSame(1, $this->lisphp->evaluate(['-', 3, 2]));
    }

    /**
     * @test
     */
    public function evaluate_multiplication()
    {
        $this->assertSame(6, $this->lisphp->evaluate(['*', 2, 3]));
    }

    /**
     * @test
     */
    public function evaluate_division()
    {
        $this->assertSame(5, $this->lisphp->evaluate(['/', 10, 2]));
    }

    /**
     * @test
     */
    public function evaluate_less_than_true()
    {
        $this->assertTrue($this->lisphp->evaluate(['<', 1, 2]));
    }

    /**
     * @test
     */
    public function evaluate_less_than_false()
    {
        $this->assertFalse($this->lisphp->evaluate(['<', 2, 1]));
        $this->assertFalse($this->lisphp->evaluate(['<', 2, 2]));
    }

    /**
     * @test
     */
    public function evaluate_less_than_or_equal_to_true()
    {
        $this->assertTrue($this->lisphp->evaluate(['<=', 1, 2]));
        $this->assertTrue($this->lisphp->evaluate(['<=', 2, 2]));
    }

    /**
     * @test
     */
    public function evaluate_less_than_or_equal_to_false()
    {
        $this->assertFalse($this->lisphp->evaluate(['<=', 2, 1]));
    }

    /**
     * @test
     */
    public function evaluate_greater_than_true()
    {
        $this->assertTrue($this->lisphp->evaluate(['>', 2, 1]));
    }

    /**
     * @test
     */
    public function evaluate_greater_than_false()
    {
        $this->assertFalse($this->lisphp->evaluate(['>', 1, 2]));
        $this->assertFalse($this->lisphp->evaluate(['>', 2, 2]));
    }

    /**
     * @test
     */
    public function evaluate_greater_than_or_equal_to_true()
    {
        $this->assertTrue($this->lisphp->evaluate(['>=', 2, 1]));
        $this->assertTrue($this->lisphp->evaluate(['>=', 2, 2]));
    }

    /**
     * @test
     */
    public function evaluate_greater_than_or_equal_to_false()
    {
        $this->assertFalse($this->lisphp->evaluate(['>=', 1, 2]));
    }

    /**
     * @test
     */
    public function evaluate_list()
    {
        $this->assertSame([1, 2, 3], $this->lisphp->evaluate(['list', 1, 2, 3]));
    }

    /**
     * @test
     */
    public function evaluate_length()
    {
        $this->assertSame(3, $this->lisphp->evaluate(['length', ['list', 1, 2, 3]]));
    }

    /**
     * @test
     */
    public function evaluate_car()
    {
        $this->assertSame(1, $this->lisphp->evaluate(['car', ['list', 1, 2, 3]]));
    }

    /**
     * @test
     */
    public function evaluate_cdr()
    {
        $this->assertSame([2, 3], $this->lisphp->evaluate(['cdr', ['list', 1, 2, 3]]));
    }

    /**
     * @test
     */
    public function evaluate_lambda_should_create_user_defined_function()
    {
        $env = LisPHP::createBaseEnv();
        $this->lisphp->evaluate(
            ['define', 'add',
                ['lambda',
                    ['x', 'y'],
                    ['+', ':x', ':y']]], $env);
        $this->assertSame(
            7,
            $this->lisphp->evaluate(['add', 3, 4], $env)
        );
    }
}
