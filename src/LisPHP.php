<?php
/**
 * LisPHP
 *
 * Lisp like language implemented in PHP.
 *
 * @package LisPHP
 * @author  Yuya Takeyama <sign.of.the.wolf.pentagram at gmail.com>
 */

require_once __DIR__ . '/LisPHP/Env.php';

/**
 * Interpreter of LisPHP.
 *
 * @author Yuya Takeyama
 */
class LisPHP
{
    /**
     * Global environment.
     *
     * @var \LisPHP\Env
     */
    protected static $_globalEnv;

    /**
     * Creates an environment has some built-in functions.
     *
     * @return \LisPHP\Env
     */
    public static function createBaseEnv()
    {
        $env = new \LisPHP\Env;
        $env['=']  = function ($x, $y) { return $x === $y; };
        $env['+']  = function ($x, $y) { return $x + $y; };
        $env['-']  = function ($x, $y) { return $x - $y; };
        $env['*']  = function ($x, $y) { return $x * $y; };
        $env['/']  = function ($x, $y) { return $x / $y; };
        $env['<']  = function ($x, $y) { return $x < $y; };
        $env['<='] = function ($x, $y) { return $x <= $y; };
        $env['>']  = function ($x, $y) { return $x > $y; };
        $env['>='] = function ($x, $y) { return $x >= $y; };
        $env['list'] = function () { return func_get_args(); };
        $env['length'] = function ($xs) { return count($xs); };
        $env['car'] = function ($xs) { return $xs[0]; };
        $env['cdr'] = function ($xs) { array_shift($xs); return $xs; };
        return $env;
    }

    /**
     * Gets global environment.
     *
     * @return \LisPHP\Env
     */
    public static function getGlobalEnv()
    {
        if (empty(self::$_globalEnv)) {
            self::$_globalEnv = self::createBaseEnv();
        }
        return self::$_globalEnv;
    }

    /**
     * Evaluates LisPHP code.
     *
     * @param  array       $x   Something to evaluate.
     * @param  \LisPHP\Env $env
     */
    public function evaluate($x, $env = NULL)
    {
        if (is_null($env)) {
            $env = $this->getGlobalEnv();
        }

        if ($this->_isSymbol($x)) {
            $symbol = $this->_toSymbol($x);
            return $env->find($symbol)[$symbol];
        } else if (! is_array($x)) {
            return $x;
        } else if ($x[0] === 'define') {
            $env[$x[1]] = $this->evaluate($x[2], $env);
        } else if ($x[0] === 'quote') {
            array_shift($x);
            return $x;
        } else if ($x[0] === 'if') {
            array_shift($x);
            list($test, $conseq, $alt) = $x;
            return $this->evaluate($this->evaluate($test, $env) ? $conseq : $alt, $env);
        } else if ($x[0] === 'lambda') {
            $vars = $x[1];
            $exp  = $x[2];
            $ctx  = $this;
            return function () use ($ctx, $exp, $vars, $env) {
                $args = func_get_args();
                return $ctx->evaluate($exp, new \LisPHP\Env($vars, $args, $env));
            };
        } else {
            $exps = [];
            foreach ($x as $i => $value) {
                if ($i === 0) {
                    $value = ":{$value}";
                }
                $exps[$i] = $this->evaluate($value, $env);
            }
            $proc = array_shift($exps);
            return call_user_func_array($proc, $exps);
        }
    }

    /**
     * Whether the input is a string as a symbol.
     *
     * @param  string $input
     * @return bool
     */
    protected static function _isSymbol($input)
    {
        return is_string($input) &&
               substr($input, 0, 1) === ':';
    }

    /**
     * Converts string into symbol.
     *
     * @param  string $input
     * @return string
     */
    protected static function _toSymbol($input)
    {
        return substr($input, 1);
    }
}
