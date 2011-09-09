<?php
/**
 * LisPHP
 *
 * Lisp like language implemented in PHP.
 *
 * @package LisPHP
 * @author  Yuya Takeyama <sign.of.the.wolf.pentagram at gmail.com>
 */

namespace LisPHP;

/**
 * Environment of LisPHP.
 *
 * @author Yuya Takeyama
 */
class Env
{
    /**
     * Constructor.
     *
     * @param  array       $params
     * @param  array       $args
     * @param  \LisPHP\Env $outer
     */
    public function __construct($params = [], $args = [], $outer = NULL)
    {}
}
