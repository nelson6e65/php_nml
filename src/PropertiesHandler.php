<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition:  [NelsonMartell]  PropertiesHandler
 *
 * Copyright © 2015-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.5.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use NelsonMartell\Extensions\Text;
use BadMethodCallException;
use InvalidArgumentException;

/**
 * Enables the class to call, implicitly, getter and setters for its properties, allowing to use properties directly.
 *
 *
 * Restricts get and set actions for a property if there is not getter/setter definicion for that property, by
 * encapsulating the class attributes.
 *
 * You can customize the properties validation/normalization without the need to call other functions/methods outside
 * the class _before_ to set the value of _after_ outputs.
 *
 * In addition, the class will be strict: any access to undefined property will be bloqued and informed in dev time.
 *
 * Also, any property can be restricted to "read-only" or "write-only" from outside the class if you simply exclude
 * the setter or getter for that property, respectively.
 *
 *
 * **Usage:**
 *
 * ***Example 1:*** Person with normalizations on its name:
 *
 * ```php
 * <?php
 * // You can document $name property using: "@property string $name Name of person" in the class definition
 * class Person implements \NelsonMartell\IStrictPropertiesContainer {
 *     use \NelsonMartell\PropertiesHandler;
 *
 *     public function __construct($name)
 *     {
 *         $this->setName($name); // Explicit call the setter inside constructor/class
 *     }
 *
 *     private $name = ''; // Property. 'private' in order to hide from inherited classes and public
 *
 *     protected function getName() // Getter. 'protected' to hide from public
 *     {
 *         return ucwords($this->name); // Format the $name output
 *     }
 *
 *     protected function setName($value) // Setter. 'protected' in order to hide from public
 *     {
 *         $this->name = strtolower($value); // Normalize the $name
 *     }
 * }
 *
 * $obj = new Person();
 * $obj->name = 'nelson maRtElL'; // Implicit call to setter
 * echo $obj->name; // 'Nelson Martell' // Implicit call to getter
 * echo $obj->Name; // Throws: InvalidArgumentException: "Name" property do not exists in "Nameable" class.
 * ```
 *
 *
 * ***Example 2:*** Same as before, but using a property wrapper (not recommended):
 *
 * ```php
 * <?php
 * class Nameable implements NelsonMartell\IStrictPropertiesContainer {
 *     use \NelsonMartell\PropertiesHandler;
 *
 *     private $_name = ''; // Attribute: Stores the value.
 *     public $name; // Property wrapper. Declare in order to be detected. Accesible name for the property.
 *
 *      public function __construct($name)
 *     {
 *         unset($this->name); // IMPORTANT: Unset the wrapper in order to redirect operations to the getter/setter
 *
 *         $this->name = $name; // Implicit call to the setter
 *     }
 *
 *     protected function getName()
 *     {
 *         return ucwords($this->_name);
 *     }
 *
 *     protected function setName($value)
 *     {
 *         $this->_name = strtolower($value);
 *     }
 * }
 *
 * $obj = new Nameable();
 * $obj->name = 'nelson maRtElL';
 * echo $obj->name; // 'Nelson Martell'
 *
 * ?>
 * ```
 *
 *
 * **Limitations:**
 * - You should not define properties wich names only are only different in the first letter upper/lowercase;
 *   it will be used the same getter/setter method (since in PHP methods are case-insensitive). In the last
 *   example, if you (in addition) define another property called `$Name`, when called, it will
 *   be used the same getter and setter method when you access or set both properties (`->Name` and `->name`).
 * - Only works for public properties (even if attribute and getter/setter methods are not `public`);
 *   this only will avoid the direct use of method (`$obj->getName(); // ERROR`), but the property
 *   value still will be accesible in child classes and public scope (`$value = $this->name; // No error`).
 * - Getter and Setter methods SHOULD NOT be declared as `private` in child classes if parent already
 *   uses this trait.
 * - Custom prefixes ability (by implementing ``ICustomPrefixedPropertiesContainer``) is not posible for
 *   multiple prefixes in multiples child classes by overriding ``ICustomPrefixedPropertiesContainer`` methods.
 *   If you extends a class that already implements it, if you override any methor to return another prefix,
 *   parent class properties may be unaccesible (know bug).
 * - Avoid the use of custom prefixes and use the standard 'get'/'set' instead. If you need to, maybe you
 *   could try to rename methods instead first.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.5.0
 * */
trait PropertiesHandler
{
    /**
     * Gets the property value using the auto-magic method `$getterPrefix.$name()` (getter),
     * where `$name` is the name of property and `$getterPrefix` is 'get' by default (but can be customized).
     *
     * @param string $name Property name.
     *
     * @return mixed
     * @throws BadMethodCallException If unable to get the property value.
     * @see PropertiesHandler::getPropertyGetter()
     * */
    public function __get($name)
    {
        try {
            $getter = static::getPropertyGetter($name);
        } catch (InvalidArgumentException $error) {
            $msg = msg('Unable to get the property value in "{0}" class.', get_class($this));
            throw new BadMethodCallException($msg, 31, $error);
        } catch (BadMethodCallException $error) {
            $msg = msg('Unable to get the property value in "{0}" class.', get_class($this));
            throw new BadMethodCallException($msg, 32, $error);
        }

        return $this->$getter();
    }


    /**
     * Sets the property value using the auto-magic method `$setterPrefix.$name()` (setter),
     * where `$name` is the name of property and `$setterPrefix` is 'set' by default (but can be customized).
     *
     * @param string $name  Property name.
     * @param mixed  $value Property value.
     *
     * @return void
     * @throws BadMethodCallException If unable to set property value.
     * @see PropertiesHandler::getPropertySetter()
     * */
    public function __set($name, $value)
    {
        try {
            $setter = static::getPropertySetter($name);
        } catch (InvalidArgumentException $error) {
            $msg = msg('Unable to set the property value in "{0}" class.', get_class($this));
            throw new BadMethodCallException($msg, 41, $error);
        } catch (BadMethodCallException $error) {
            $msg = msg('Unable to set the property value in "{0}" class.', get_class($this));
            throw new BadMethodCallException($msg, 42, $error);
        }

        $this->$setter($value);
    }


    /**
     * Ensures that property provided exists in this class.
     *
     * @param string $name Property name.
     *
     * @return string Same property name, but validated.
     * @throws InvalidArgumentException If property name is not valid (10) or do not exists (11).
     */
    protected static function ensurePropertyExists($name)
    {
        $args = [
            'class'    => get_called_class(),
        ];

        try {
            $args['property'] = Text::ensureIsValidVarName($name);
        } catch (InvalidArgumentException $error) {
            $msg = msg('Property name is not valid.');
            throw new InvalidArgumentException($msg, 10, $error);
        }

        if (!property_exists($args['class'], $args['property'])) {
            // Check in parent classes for private property
            $current = $args['class'];
            $exists = false;
            while ($current = get_parent_class($current) and !$exists) {
                $exists = property_exists($current, $args['property']);
            }

            if (!$exists) {
                $msg = msg(
                    '"{property}" property do not exists in "{class}" class or parent classes.',
                    $args
                );
                throw new InvalidArgumentException($msg, 11);
            }
        }

        return $name;
    }


    /**
     * Ensures that method provided exists in this class.
     *
     * @param string $name Method name.
     *
     * @return string Same method name, but validated.
     * @throws InvalidArgumentException If method name is not valid (20) or do not exists (21).
     */
    protected static function ensureMethodExists($name)
    {
        $args = [
            'class'  => get_called_class(),
        ];

        try {
            $args['method'] = Text::ensureIsValidVarName($name);
        } catch (InvalidArgumentException $error) {
            $msg = msg('Method name is not valid.');
            throw new InvalidArgumentException($msg, 20, $error);
        }

        if (method_exists($args['class'], $args['method']) === false) {
            $msg = msg('"{class}::{method}" do not exists.', $args);

            throw new InvalidArgumentException($msg, 21);
        }

        return $name;
    }


    /**
     * Gets the property setter method name.
     * You can customize the setter prefix by implementing ``ICustomPrefixedPropertiesContainer`` interface.
     *
     * @param string $name Property name.
     *
     * @return string
     * @throws InvalidArgumentException If property is not valid or has not setter.
     * @throws BadMethodCallException If custom prefix is not an ``string`` instance.
     * @see ICustomPrefixedPropertiesContainer::getCustomSetterPrefix()
     */
    protected static function getPropertySetter($name)
    {
        $args = [
            'class' => get_called_class(),
        ];

        $prefix = 'set';

        $args['name'] = static::ensurePropertyExists($name, $args['class']);

        try {
            $setter = static::ensureMethodExists($prefix.$args['name']);
        } catch (InvalidArgumentException $error) {
            $msg = msg('"{name}" property has not a setter method in "{class}".', $args);

            if (is_subclass_of($args['class'], ICustomPrefixedPropertiesContainer::class)) {
                // If not available standard setter, check if custom available
                try {
                    $prefix = Text::ensureIsString(static::getCustomSetterPrefix());
                } catch (InvalidArgumentException $e) {
                    $msg = msg(
                        '"{class}::getCustomSetterPrefix" method must to return an string.',
                        $args['class']
                    );

                    throw new BadMethodCallException($msg, 31, $e);
                }

                try {
                    $setter = static::ensureMethodExists($prefix.$args['name']);
                } catch (InvalidArgumentException $e) {
                    throw new InvalidArgumentException($msg, 32, $e);
                }
            } else {
                // Error for non custom prefixes
                throw new InvalidArgumentException($msg, 30, $error);
            }
        }

        return $setter;
    }


    /**
     * Gets the property getter method name.
     * You can customize the getter prefix by implementing ``ICustomPrefixedPropertiesContainer`` interface.
     *
     * @param string $name Property name.
     *
     * @return string
     * @throws InvalidArgumentException If property is not valid or has not getter.
     * @throws BadMethodCallException If custom prefix is not an ``string`` instance.
     * @see ICustomPrefixedPropertiesContainer::getCustomGetterPrefix()
     */
    protected static function getPropertyGetter($name)
    {
        $args = [
            'class' => get_called_class(),
        ];

        $prefix = 'get';

        $args['name'] = static::ensurePropertyExists($name, $args['class']);

        try {
            $getter = static::ensureMethodExists($prefix.$args['name']);
        } catch (InvalidArgumentException $error) {
            $msg = msg('"{name}" property has not a getter method in "{class}".', $args);

            if (is_subclass_of($args['class'], ICustomPrefixedPropertiesContainer::class)) {
                // If not available standard getter, check if custom available
                try {
                    $prefix = Text::ensureIsString(static::getCustomGetterPrefix());
                } catch (InvalidArgumentException $e) {
                    $msg = msg(
                        '"{class}::getCustomGetterPrefix" method must to return an string.',
                        $args['class']
                    );

                    throw new BadMethodCallException($msg, 31, $e);
                }

                try {
                    $getter = static::ensureMethodExists($prefix.$args['name']);
                } catch (InvalidArgumentException $e) {
                    throw new InvalidArgumentException($msg, 32, $e);
                }
            } else {
                // Error for non custom prefixes
                throw new InvalidArgumentException($msg, 30, $error);
            }
        }

        return $getter;
    }
}
