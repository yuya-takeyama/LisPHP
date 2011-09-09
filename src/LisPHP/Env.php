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
class Env implements \ArrayAccess
{
    /**
     * Variables the env has.
     *
     * @var array
     */
    protected $_vars = [];

    /**
     * Constructor.
     *
     * @param  array       $params
     * @param  array       $args
     * @param  \LisPHP\Env $outer
     */
    public function __construct($params = [], $args = [], $outer = NULL)
    {}

    /**
     * Assigns a value to a variable.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    /**
     * Gets a value from a variable.
     *
     * @param  string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->_vars[$key];
    }

    /**
     * Whether the variable exists.
     *
     * @param  string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->_vars[$key]);
    }

    /**
     * Unsets a variable.
     *
     * @param  string
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->_vars[$key]);
    }
}
