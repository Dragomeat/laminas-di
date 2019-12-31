<?php

/**
 * @see       https://github.com/laminas/laminas-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-di/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Di\Definition;

/**
 * Class definitions for a single class
 *
 * @category   Laminas
 * @package    Laminas_Di
 */
class ClassDefinition implements DefinitionInterface, PartialMarker
{
    /**
     * @var null|string
     */
    protected $class = null;

    /**
     * @var string[]
     */
    protected $supertypes = array();

    /**
     * @var null|\Callable|array|string
     */
    protected $instantiator = null;

    /**
     * @var bool[]
     */
    protected $methods = array();

    /**
     * @var array
     */
    protected $methodParameters = array();

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param  null|\Callable|array|string $instantiator
     * @return self
     */
    public function setInstantiator($instantiator)
    {
        $this->instantiator = $instantiator;

        return $this;
    }

    /**
     * @param  string[] $supertypes
     * @return self
     */
    public function setSupertypes(array $supertypes)
    {
        $this->supertypes = $supertypes;

        return $this;
    }

    /**
     * @param  string    $method
     * @param  bool|null $isRequired
     * @return self
     */
    public function addMethod($method, $isRequired = null)
    {
        if ($isRequired === null) {
            $isRequired = ($method === '__construct') ? true : false;
        }
        $this->methods[$method] = (bool) $isRequired;

        return $this;
    }

    /**
     * @param $method
     * @param $parameterName
     * @param  array           $parameterInfo (keys: required, type)
     * @return ClassDefinition
     */
    public function addMethodParameter($method, $parameterName, array $parameterInfo)
    {
        if (!array_key_exists($method, $this->methods)) {
            $this->methods[$method] = ($method === '__construct') ? true : false;
        }

        if (!array_key_exists($method, $this->methodParameters)) {
            $this->methodParameters[$method] = array();
        }

        $type     = (isset($parameterInfo['type'])) ? $parameterInfo['type'] : null;
        $required = (isset($parameterInfo['required'])) ? (bool) $parameterInfo['required'] : false;
        $default  = (isset($parameterInfo['default'])) ? $parameterInfo['default'] : null;

        $fqName = $this->class . '::' . $method . ':' . $parameterName;
        $this->methodParameters[$method][$fqName] = array(
            $parameterName,
            $type,
            $required,
            $default
        );

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses()
    {
        return array($this->class);
    }

    /**
     * {@inheritDoc}
     */
    public function hasClass($class)
    {
        return ($class === $this->class);
    }

    /**
     * {@inheritDoc}
     */
    public function getClassSupertypes($class)
    {
        if ($this->class !== $class) {
            return array();
        }
        return $this->supertypes;
    }

    /**
     * {@inheritDoc}
     */
    public function getInstantiator($class)
    {
        if ($this->class !== $class) {
            return null;
        }
        return $this->instantiator;
    }

    /**
     * {@inheritDoc}
     */
    public function hasMethods($class)
    {
        return (count($this->methods) > 0);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethods($class)
    {
        if ($this->class !== $class) {
            return array();
        }
        return $this->methods;
    }

    /**
     * {@inheritDoc}
     */
    public function hasMethod($class, $method)
    {
        if ($this->class !== $class) {
            return null;
        }

        if (is_array($this->methods)) {
            return array_key_exists($method, $this->methods);
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasMethodParameters($class, $method)
    {
        if ($this->class !== $class) {
            return false;
        }
        return (array_key_exists($method, $this->methodParameters));
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodParameters($class, $method)
    {
        if ($this->class !== $class) {
            return null;
        }

        if (array_key_exists($method, $this->methodParameters)) {
            return $this->methodParameters[$method];
        }

        return null;
    }
}
