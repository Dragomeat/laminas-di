<?php

/**
 * @see       https://github.com/laminas/laminas-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-di/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Di\Definition\Builder;

/**
 * Definitions for an injection endpoint method
 *
 * @category   Laminas
 * @package    Laminas_Di
 */
class InjectionMethod
{
    /**
     * @var string|null
     */
    protected $name = null;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @param  string|null $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string          $name
     * @param  string|null     $class
     * @param  mixed|null      $isRequired
     * @param  mixed|null      $default
     * @return InjectionMethod
     */
    public function addParameter($name, $class = null, $isRequired = null, $default = null)
    {
        $this->parameters[] = array(
            $name,
            $class,
            ($isRequired == null) ? true : false,
            $default,
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
