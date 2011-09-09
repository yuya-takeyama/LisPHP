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

class LisPHP
{
    /**
     * Global environment.
     *
     * @var \LisPHP\Env
     */
    protected static $_globalEnv;

    /**
     * Gets global environment has some functions.
     *
     * @return \LisPHP\Env
     */
    protected static function getGlobalEnv()
    {
        if (empty(self::$_globalEnv)) {
            self::$_globalEnv = new \LisPHP\Env;
            self::$_globalEnv['+'] = function ($x, $y) { return $x + $y; };
            self::$_globalEnv['-'] = function ($x, $y) { return $x - $y; };
            self::$_globalEnv['*'] = function ($x, $y) { return $x * $y; };
            self::$_globalEnv['/'] = function ($x, $y) { return $x / $y; };
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
            return $this->evaluate($this->evaluate($test, $env) ? $conseq : $alt);
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
