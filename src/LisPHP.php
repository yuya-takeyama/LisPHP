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
     * Evaluates LisPHP code.
     *
     * @param  array       $x   Something to evaluate.
     * @param  \LisPHP\Env $env
     */
    public function evaluate($x, $env = NULL)
    {
        if (is_string($x)) {
            return $env->find($x)[$x];
        } else if (! is_array($x)) {
            return $x;
        } else {
            if ($x[0] === 'define') {
                $env[$x[1]] = $this->evaluate($x[2], $env);
            }
        }
    }
}
