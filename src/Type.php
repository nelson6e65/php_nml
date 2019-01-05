<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2013-2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2013-2015 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use ReflectionException;
use InvalidArgumentException;

/**
 * Represents a PHP object type, and provides some properties and methods to
 * describe some info about itself.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.1.1
 *
 * @property-read string        $name      Gets the name of this Type. This property is read-only.
 * @property-read string        $shortName Gets the abbreviated name of class, in other words, without the namespace.
 *   This property is read-only.
 * @property-read string|null   $namespace Gets the namespace name of this class. If this Type is not a class, this
 *   property is set to `null`. This property is read-only.
 * @property-read string|null   $methods   Gets the public|protected methods (ReflectionMethod) of this Type. This
 *   property is read-only.
 * @property-read string|null   $vars      Gets the public|protected properties (ReflectionProperty) of this Type.
 *   This property is read-only.
 *
 * */
final class Type extends StrictObject implements IEquatable
{

    /**
     * Gets the type of specified $obj and collect some info about itself.
     *
     * @param string|mixed  $obj         Target object.
     * @param bool          $searchName Set this to `true` if `$obj` is a class name instead of an instance.
     *   This param is ignored if `obj` is not a `string`.
     *
     * @throws InvalidArgumentException If `$obj` is not a class name when `$searchName` is `true`.
     *
     * @since 1.0.0 Allow construct from a class name string.
     * */
    public function __construct($obj, bool $searchName = false)
    {
        parent::__construct();

        $name      = (is_string($obj) && $searchName === true) ? 'object' : gettype($obj);
        $shortName = null;
        $namespace = null;
        $vars      = [];
        $methods   = [];
        $ref       = null;

        switch ($name) {
            case 'object':
                try {
                    $ref = new ReflectionClass($obj);
                } catch (ReflectionException $e) {
                    $msg  = msg('Invalid value.');
                    $msg .= msg(' `{0}` (position {1}) must to be a name of an existing class.', 'obj', 0);

                    throw new InvalidArgumentException($msg, 1, $e);
                }

                $name      = $ref->getName();
                $shortName = $ref->getShortName();
                $namespace = $ref->getNamespaceName();
                break;

            case 'resource':
                $shortName = get_resource_type($obj);
                $name      = 'resource: '.$shortName;
                break;

            default:
                $shortName = $name;
        }

        $this->name             = $name;
        $this->shortName        = $shortName;
        $this->namespace        = $namespace;
        $this->vars             = $vars;
        $this->methods          = $methods;
        $this->reflectionObject = $ref;
    }

    /**
     * @var ReflectionClass|null
     */
    private $reflectionObject = null;

    private $name;

    /**
     * Getter for `$name` property.
     *
     * @return string
     * @see Type::$name
     * */
    protected function getName()
    {
        return $this->name;
    }

    private $shortName = null;

    /**
     * Getter for `$shortName` property.
     *
     * @return string
     * @see Type::$shortName
     * */
    public function getShortName()
    {
        return $this->shortName;
    }

    private $namespace;

    /**
     * Getter for `$namespace` property.
     *
     * @return string|null
     * @see    Type::$namespace
     * */
    public function getNamespace()
    {
        return $this->namespace;
    }

    private $vars = null;

    /**
     * Getter for `$vars` property.
     *
     * @return array
     */
    public function getVars()
    {
        if ($this->vars == null) {
            $this->vars = $this->reflectionObject->getProperties(
                ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED
            );
        }
        return $this->vars;
    }

    private $methods = null;

    /**
     * Getter for `$methods` property.
     *
     * @return array
     * @see    Type::$methods
     */
    public function getMethods()
    {
        if ($this->methods == null) {
            $this->methods = $this->reflectionObject->getMethods(
                ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED
            );
        }
        return $this->methods;
    }

    /**
     * Checks if the type has a method.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMethod($name)
    {
        if ($this->reflectionObject !== null) {
            return $this->reflectionObject->hasMethod($name);
        }

        return false;
    }

    /**
     * Determines if instances of this Type can be converted to string.
     *
     *
     * @return bool
     */
    public function canBeString()
    {
        if ($this->isNull() || $this->isScalar() || $this->hasMethod('__toString')) {
            return true;
        }

        return false;
    }

    /**
     * Determina si este Type es `null`.
     *
     * @return bool `true` if this type is `null`; other case, `false`.
     * */
    public function isNull()
    {
        if ($this->name == 'NULL' || $this->name == 'null') {
            return true;
        }

        return false;
    }

    /**
     * Determina si este Type NO es `null`.
     *
     * @return bool `true` if this type is NOT `null`; other case, `false`.
     * */
    public function isNotNull()
    {
        return !$this->isNull();
    }


    /**
     * Determina si este Type es una clase personalizada.
     *
     * @return bool `true`, if this Type is a custom class; another case,
     *   `false`.
     * */
    public function isCustom()
    {
        return !$this->isValueType() && $this->isNotNull();
    }

    /**
     * Determinate if this type is scalar.
     *
     * @return bool
     * @see    \is_scalar()
     * */
    public function isScalar()
    {
        $r = false;

        switch ($this->name) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
                $r = true;
                break;

            default:
                $r = false;
        }

        return $r;
    }

    /**
     * Determina si este Type es de tipo valor.
     *
     * @return bool
     * */
    public function isValueType()
    {
        if ($this->isScalar() || $this->name === 'array') {
            return true;
        }

        return false;
    }

    /**
     * Determina si este Type es de tipo referencia.
     *
     * @return bool
     * */
    public function isReferenceType()
    {
        return !$this->isValueType();
    }

    /**
     * Convierte la instancia actual en su representación en cadena.
     *
     * @return string
     * */
    public function toString()
    {
        $s = $this->name;

        if ($this->isCustom()) {
            $s = sprintf('object (%s)', $s);
        }

        return $s;
    }


    /**
     * Indicates whether the specified object is equal to the current instance.
     *
     * @param Type|mixed $other
     *
     * @return bool Returns always `false` if `$other` is not a `Type`.
     */
    public function equals($other)
    {
        if ($other instanceof Type) {
            return $this->name == $other->name;
        } else {
            return false;
        }
    }

    /**
     * Detect if at least one of the objects are from this type.
     *
     * **Usage:**
     *
     * ```php
     * $var1 = 'Hola, mundo';
     * $oneIsString = typeof((string) '')->isIn($var1, 1, 34); // true
     * ```
     *
     * Also works with 1st dimention of arrays:
     * ```php
     * $vars = ['Hola, mundo', 1, 34];
     * $oneIsString = typeof((string) '')->isIn($vars); // true
     * ```
     *
     * @param array $args List of object to check type.
     *
     * @return bool
     *
     * @see typeof()
     * @see Type::is()
     * @since 1.0.0
     */
    public function isIn(...$args)
    {
        foreach ($args as $obj) {
            if ($this->equals(typeof($obj))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if all object are from this type.
     *
     * * **Usage:**
     *
     * ```php
     * $var1 = 'Hola, mundo';
     * $allAreString = typeof((string) '')->isIn($var1, 1, 34); // false
     * $allAreString = typeof((string) '')->isIn($var1, '1', '34'); // true
     * ```
     *
     * Also works with 1st dimention of arrays:
     * ```php
     * $vars = ['Hola, mundo', '1', '34'];
     * $allAreString = typeof((string) '')->isIn($vars); // true
     * ```
     *
     * @param array $args List of object to check type.
     *
     * @return bool
     *
     * @see typeof()
     * @see Type::isIn()
     * @since 1.0.0
     */
    public function is(...$args)
    {
        foreach ($args as $obj) {
            if (!$this->equals(typeof($obj))) {
                return false;
            }
        }

        return true;
    }
}
