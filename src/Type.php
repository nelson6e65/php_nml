<?php declare(strict_types=1);
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2013-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2013-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Represents a PHP object type. Provides some properties and methods to describe some info about itself.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.1.1
 *
 * @property-read string        $name      Gets the name of this Type. This property is read-only.
 * @property-read string        $shortName Gets the abbreviated name of class, in other words, without the namespace.
 *   This property is read-only.
 * @property-read string        $namespace Gets the namespace name of this class. If the underlying type is not a class,
 *   this property is set to `''` (empty string). This property is read-only.
 * */
final class Type extends StrictObject implements IEquatable
{

    /**
     * Gets the type of specified $obj and collect some info about itself.
     *
     * @param string|mixed  $obj        Target object or `class`|`interface`|`trait` name.
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

        $type = (is_string($obj) && $searchName === true) ? 'object' : gettype($obj);

        $this->namespace = '';

        switch ($type) {
            case 'object':
                try {
                    $this->reflectionObject = new ReflectionClass($obj);
                } catch (ReflectionException $e) {
                    $msg  = msg('Invalid value.');
                    $msg .= msg(' `{0}` (position {1}) must to be a name of an existing class.', 'obj', 0);

                    throw new InvalidArgumentException($msg, 1, $e);
                }

                $this->name      = $this->reflectionObject->getName();
                $this->shortName = $this->reflectionObject->getShortName();
                $this->namespace = $this->reflectionObject->getNamespaceName();
                break;

            case 'resource':
                $this->shortName = get_resource_type($obj);
                $this->name      = 'resource: '.$this->shortName;
                break;

            default:
                $this->shortName = $this->name = $type;
        }
    }

    /**
     * @var ReflectionClass
     */
    private $reflectionObject = null;

    /**
     * @var string
     */
    private $name;

    /**
     * Getter for `$name` property.
     *
     * @return string
     * @see Type::$name
     * */
    protected function getName() : string
    {
        return $this->name;
    }

    /**
     * @var string
     */
    private $shortName;

    /**
     * Getter for `$shortName` property.
     *
     * @return string
     * @see Type::$shortName
     * */
    public function getShortName() : string
    {
        return $this->shortName;
    }

    /**
     * @var string
     */
    private $namespace = '';

    /**
     * Getter for `$namespace` property.
     *
     * @return string
     * @see    Type::$namespace
     * */
    public function getNamespace() : string
    {
        return $this->namespace;
    }

    /**
     *
     * @param int $filters
     *
     * @return ReflectionProperty[]|array
     *
     * @deprecated 1.0.0 Use `Type::getProperties()` instead.
     *
     * @see Type::getProperties()
     */
    public function getVars(int $filters = ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED) : array
    {
        return $this->getProperties($filter);
    }

    /**
     * Gets the properties of underlying type of this instance
     *
     * @param int $filters Filter the results to include only properties with certain attributes. Defaults to
     *   `ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED`. Any combination of
     *   `ReflectionMethod::IS_STATIC`, `ReflectionMethod::IS_PUBLIC`, `ReflectionMethod::IS_PROTECTED`,
     *   `ReflectionMethod::IS_PRIVATE`.
     *
     * @return ReflectionProperty[]|array
     *
     * @since 1.0.0 Replacement for `Type::getVars()`
     */
    public function getProperties(
        int $filters = ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED
    ) : array {
        if ($this->reflectionObject != null) {
            return $this->reflectionObject->getProperties($filters);
        }

        return [];
    }


    /**
     * Gets the public|protected methods (ReflectionMethod) of the underlying type of this instance.
     *
     * @param int $filters Filter the results to include only methods with certain attributes. Defaults to
     *   `ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED`. Any combination of
     *   `ReflectionMethod::IS_STATIC`, `ReflectionMethod::IS_PUBLIC`, `ReflectionMethod::IS_PROTECTED`,
     *   `ReflectionMethod::IS_PRIVATE`, `ReflectionMethod::IS_ABSTRACT` and `ReflectionMethod::IS_FINAL`.
     *
     * @return ReflectionMethod[]|array
     *
     * @since 1.0.0 Add `$filters` param.
     */
    public function getMethods(int $filters = ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED) : array
    {
        if ($this->reflectionObject != null) {
            return $this->reflectionObject->getMethods($filters);
        }

        return [];
    }

    /**
     * Checks if the specified method is defined in the underlying type of this instance.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMethod(string $name) : bool
    {
        if ($this->reflectionObject !== null) {
            return $this->reflectionObject->hasMethod($name);
        }

        return false;
    }

    /**
     * Gets a list of all interfaces of the underlying type of this instance.
     *
     * @param bool $reflection If set to `true`, returns a list of interfaces as `ReflectionClass` (keyed by its names)
     *   instead of a list of names only (`string`).
     *
     * @return ReflectionClass[]|string[]|array
     *
     * @since 1.0.0
     */
    public function getInterfaces(bool $reflection = false) : array
    {
        if ($this->reflectionObject !== null) {
            if ($reflection === true) {
                return $this->reflectionObject->getInterfaces();
            } else {
                return $this->reflectionObject->getInterfaceNames();
            }
        }

        return [];
    }


    /**
     * Gets a list of traits used by the underlying type of this instance.
     *
     * @param bool $reflection If set to `true`, returns a list of interfaces as `ReflectionClass` (keyed by its names)
     *   instead of a list of names only (`string`).
     * @param bool $recursive  If set to `true` will get all traits used by parent classes and used traits.
     *
     * @return array
     *
     * @since 1.0.0
     */
    public function getTraits(bool $reflection = false, bool $recursive = false) : array
    {
        $traits = [];

        if ($this->reflectionObject !== null) {
            $traits += (array) $this->reflectionObject->getTraits();

            if ($recursive === true) {
                // Search in sub-traits of this class --------------------------------------------
                foreach ($traits as $name => $traitClass) {
                    $traits += typeof($name, true)->getTraits(true, true);
                }

                // Search in parent class
                $parent = $this->reflectionObject->getParentClass();

                if ($parent) { // Search in parent class
                    $traits += typeof($parent->getName(), true)->getTraits(true, true);
                }
            }
        }

        if (count($traits) && !$reflection) {
            $traits = array_keys($traits); // Get only names if `$reflection == false`
        }

        return $traits;
    }


    /**
     * Checks if the specified property is defined in the underlying type of this instance.
     *
     * Unlike `property_exists()` function, this method returns `false` for dynamic attributes of an object.
     *
     * This method is ***case-sensitive***.
     *
     * @param string $name         Name of property.
     * @param bool   $recursive    Indicates if search for inherithed properties. Default: `true`.
     * @param bool   $includeMagic Include check for properties in class DocBlock definition.
     *
     * @return bool
     *
     * @since 1.0.0
     *
     * @see ReflectionClass::hasProperty()
     * @see \property_exists()
     */
    public function hasProperty(string $name, bool $recursive = true, bool $includeMagic = false) : bool
    {
        if ($this->reflectionObject !== null) {
            $itHas = $this->reflectionObject->hasProperty($name);

            if (!$itHas && $includeMagic) {
                $pattern = '/\* @(?P<tag>property-read|property-write|property) +'.
                    '(?P<types>([a-zA-Z]+[\[\]]*\|?)+) +(?P<property>\$'.$name.') *(?P<description>.*)/';

                $itHas = preg_match($pattern, $this->reflectionObject->getDocComment()) > 0;
            }

            if ($itHas == false && $recursive === true) {
                /**
                 * @var ReflectionClass|bool
                 */
                $parentClass = $this->reflectionObject->getParentClass();

                if ($parentClass != false) {
                    $itHas = typeof($parentClass->getName(), true)->hasProperty($name, true, $includeMagic);
                }
            }

            return $itHas;
        }

        return false;
    }

    /**
     * Determines if instances of the underlying type can be converted to `string`.
     *
     * @return bool
     */
    public function canBeString() : bool
    {
        if ($this->isNull() || $this->isScalar() || $this->hasMethod('__toString')) {
            return true;
        }

        return false;
    }

    /**
     * Determines if the underlying type is `null`.
     *
     * @return bool `true` if this type is `null`; other case, `false`.
     * */
    public function isNull() : bool
    {
        if ($this->name == 'NULL' || $this->name == 'null') {
            return true;
        }

        return false;
    }

    /**
     * Determines if the underlying type is NOT `null`.
     *
     * @return bool `true` if this type is NOT `null`; other case, `false`.
     *
     * @deprecated 1.0.0 Use `!Type::isNull()` instead
     *
     * @see Type::isNull()
     * */
    public function isNotNull() : bool
    {
        return !$this->isNull();
    }


    /**
     * Determines if the underlying type of this instance is a custom `class`.
     *
     * @return bool `true`, if the underlying type is a custom class; another case, `false`.
     * */
    public function isCustom() : bool
    {
        return !$this->isValueType() && !$this->isNull();
    }

    /**
     * Determines if the underlying type of this instance is scalar.
     *
     * @return bool
     * @see    \is_scalar()
     * */
    public function isScalar() : bool
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
     * Determines if the underlying type of this instance is value type.
     *
     * @return bool
     * */
    public function isValueType() : bool
    {
        if ($this->isScalar() || $this->name === 'array') {
            return true;
        }

        return false;
    }

    /**
     * Determines if the underlying type of this instance is ref type.
     *
     * @return bool
     * */
    public function isReferenceType() : bool
    {
        return !$this->isValueType();
    }

    /**
     * Converts the current instance to its `string` representation.
     *
     * @return string
     * */
    public function toString() : string
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
    public function equals($other) : bool
    {
        if ($other instanceof Type) {
            return $this->name == $other->name;
        } else {
            return false;
        }
    }

    /**
     * Detects if at least one of the objects are from the underlying type.
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
    public function isIn(...$args) : bool
    {
        foreach ($args as $obj) {
            if ($this->equals(typeof($obj))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detects if all object are from the underlying type.
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
    public function is(...$args) : bool
    {
        foreach ($args as $obj) {
            if (!$this->equals(typeof($obj))) {
                return false;
            }
        }

        return true;
    }
}
