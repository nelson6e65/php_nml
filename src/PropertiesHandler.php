<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition:  [NelsonMartell]  PropertiesHandler
 *
 * Copyright © 2015-2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.5.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    use NelsonMartell\Extensions\Text;
    use \BadMethodCallException;
    use \InvalidArgumentException;

    /**
     * Enables the class to use properties, by encapsulating class attributes in order to use with
     * auto-setters/getters methods instead of direct access.
     *
     * Using this trail will restrict get and set actions for a property if there is not defined in
     * the class or if there is not a getter or setter method (respectively) for that property.
     *
     * So, you MUST (1) create the property in the class and (2) then unset it in the constructor
     * (*this requirements will change in next releases to be more 'auto-magic'*).
     *
     * @example
     * ```php
     * <?php
     * class Nameable {
     *     use NelsonMartell\PropertiesHandler;
     *
     *     public function __construct()
     *     {
     *         unset($this->Name);
     *     }
     *
     *     private $_name = ''; // Stores the value.
     *     public $Name; // Accesible name for the property.
     *
     *     public function getName()
     *     {
     *         return ucwords($this->_name);
     *     }
     *
     *     public function setName($value)
     *     {
     *         $this->_name = strtolower($value);
     *     }
     * }
     *
     * $obj = new Nameable();
     * $obj->Name = 'nelson maRtElL';
     * echo $obj->Name; // 'Nelson Martell'
     * echo $obj->name; // Throws: BadMethodCallException: Property "Nameable::name" do not exists.
     *
     * ?>
     * ```
     *
     * **Note**: You should not define properties wich names only are only different in the first letter
     * upper/lowercase; it will be used the same getter/setter method. In the last example, if you (in addition)
     * define the `public $name` and `unset($this->name)` in the constructor, it will be used the same
     * getter and setter method when you access or set both properties (`->Name` and `->name`).
     *
     * ### Limitations
     * - Only works for public properties (even if you declare getter/setter method as `private` or `protected`).
     *
     * @author Nelson Martell <nelson6e65@gmail.com>
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
                $getter = $this->getPropertyGetter($name);
            } catch (BadMethodCallException $error) {
                $msg = nml_msg('Unable to get the property value in "{0}" class.', typeof($this)->Name);
                throw new BadMethodCallException($msg, 31, $error);
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
                $setter = $this->getPropertySetter($name);
            } catch (BadMethodCallException $error) {
                $msg = nml_msg('Unable to set the property value in "{0}" class.', typeof($this)->Name);
                throw new BadMethodCallException($msg, 41, $error);
            }

            $this->$setter($value);
        }


        /**
         * Ensures that property provided exists in this class.
         *
         * @param string $name Property name.
         *
         * @return string Same property name, but validated.
         * @throws BadMethodCallException If property do not exists or name is invalid.
         */
        private function ensurePropertyExists($name)
        {
            try {
                $pName = Text::ensureIsValidVarName($name);
            } catch (InvalidArgumentException $error) {
                $msg = nml_msg('Property name is not valid.');
                throw new BadMethodCallException($msg, 10, $error);
            }

            if (property_exists($this, $name) === false) {
                $args = [
                         'class'    => typeof($this)->Name,
                         'property' => $name,
                        ];

                $msg = nml_msg('Property "{class}::{property}" do not exists.', $args);

                throw new BadMethodCallException($msg, 11);
            }

            return $name;
        }


        /**
         * Ensures that method provided exists in this class.
         *
         * @param string $name Method name.
         *
         * @return string Same method name, but validated.
         * @throws BadMethodCallException If method name is invalid or do not exists.
         */
        private function ensureMethodExists($name)
        {
            try {
                $mName = Text::ensureIsValidVarName($name);
            } catch (InvalidArgumentException $error) {
                $msg = nml_msg('Method name is not valid.');
                throw new BadMethodCallException($msg, 20, $error);
            }

            if (method_exists($this, $name) === false) {
                $args = [
                         'class'  => typeof($this)->Name,
                         'method' => $name,
                        ];

                $msg = nml_msg('Method "{class}::{method}" do not exists.', $args);

                throw new BadMethodCallException($msg, 21);
            }

            return $name;
        }


        /**
         * Ensures that there is a setter for the provided property name.
         *
         * @param string $name   Property name.
         * @param string $prefix Property setter prefix. Default: 'set'.
         *
         * @return string Same property name, after checks that setter exists.
         * @throws BadMethodCallException If property is not writable or do not exists.
         */
        private function ensurePropertyHasSetter($name, $prefix = 'set')
        {
            $setter = $prefix.$this->ensurePropertyExists($name);

            try {
                $setter = $this->ensureMethodExists($setter);
            } catch (BadMethodCallException $error) {
                $args = [
                         'class' => typeof($this)->Name,
                         'name'  => $name,
                        ];

                $msg = nml_msg('Property "{class}::{name}" has not a setter.', $args);

                throw new BadMethodCallException($msg, 40, $error);
            }

            return $name;
        }


        /**
         * Ensures that there is a getter for the provided property name.
         *
         * @param string $name   Property name.
         * @param string $prefix Property getter prefix. Default: 'get'.
         *
         * @return string Same property name, after checks that getter exists.
         * @throws BadMethodCallException If property is not readable or do not exists.
         */
        private function ensurePropertyHasGetter($name, $prefix = 'get')
        {
            $getter = $prefix.$this->ensurePropertyExists($name);

            try {
                $getter = $this->ensureMethodExists($getter);
            } catch (BadMethodCallException $error) {
                $args = [
                         'class' => typeof($this)->Name,
                         'name'  => $name,
                        ];

                $msg = nml_msg('Property "{class}::{name}" has not a getter.', $args);

                throw new BadMethodCallException($msg, 30, $error);
            }

            return $name;
        }


        /**
         * Gets the property setter method name.
         * You can customize the getter prefix by creating the protected `setterPrefix` attribute in your class.
         *
         * @param string $name Property name.
         *
         * @return string
         * @throws BadMethodCallException if property is not valid, has not setter or custom prefix is not
         *   an ``string`` instance.
         */
        private function getPropertySetter($name)
        {
            $prefix = 'set';
            if (property_exists($this, 'setterPrefix')) {
                try {
                    $prefix = Text::ensureIsString($this->setterPrefix);
                } catch (InvalidArgumentException $e) {
                    $msg = nml_msg(
                        'Custom property setter prefix is defined, but its value should be an "string"; "{0}" given.',
                        [typeof($this->setterPrefix)]
                    );

                    throw new BadMethodCallException($msg, 0, $e);
                }
            }

            return $prefix.$this->ensurePropertyHasSetter($name, $prefix);
        }


        /**
         * Gets the property getter method name.
         * You can customize the getter prefix by creating the protected `getterPrefix` attribute in your class.
         *
         * @param string $name Property name.
         *
         * @return string
         * @throws BadMethodCallException if property is not valid, has not getter or custom prefix is not
         *   an ``string`` instance.
         */
        private function getPropertyGetter($name)
        {
            $prefix = 'get';
            if (property_exists($this, 'getterPrefix')) {
                try {
                    $prefix = Text::ensureIsString($this->getterPrefix);
                } catch (InvalidArgumentException $e) {
                    $msg = nml_msg(
                        'Custom property getter prefix is defined, but its value should be an "string"; "{0}" given.',
                        [typeof($this->getterPrefix)]
                    );

                    throw new BadMethodCallException($msg, 0, $e);
                }
            }

            return $prefix.$this->ensurePropertyHasGetter($name, $prefix);
        }
    }
}
