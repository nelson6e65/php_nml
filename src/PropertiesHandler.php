<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition:  [NelsonMartell]  PropertiesHandler
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.5.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    use NelsonMartell\Extensions\String;
    use \BadMethodCallException;

    /**
     * Permite encapsular propiedades para usar setters y getters automáticamente.
     * Por defecto, esta funcionalidad viene por defecto en la clase Object.
     *
     * Nota: Los nombres de las propiedades deberían estar en CamelCase (primera
     * letra en mayúscula) para que, por ejemplo, los getters queden `getName()`
     * y se accedan $obj->Name.
     *
     * @author Nelson Martell <nelson6e65-dev@yahoo.es>
     * */
    trait PropertiesHandler
    {
        /**
         * Prefix for methods witch get properties value.
         * You can override to use another prefix.
         * @var string
         */
        protected static $getterPrefix = 'get';

        /**
         * Prefix for methods witch set properties value.
         * You can override to use another prefix.
         * @var string
         */
        protected static $setterPrefix = 'set';


        /**
         * Obtiene el valor de una propiedad, usando automáticamente el método
         * `$getterPrefix + nombre_propiedad` (getter).
         *
         * Restringe la obtención de una propiedad no definida dentro de la clase
         * si no posee su método getter.
         *
         * @param string $name Property name.
         *
         * @see    PropertiesHandler::$getterPrefix
         * @return mixed
         * @throws BadMethodCallException If unable to get the property value.
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
         * Establece el valor de una propiedad, usando automáticamente el método
         * `$setterPrefix + nombre_propiedad` (setter).
         * Restringe la asignación de una propiedad no definida dentro de la clase
         * si no posee su método setter.
         *
         * @param string $name  Property name.
         * @param mixed  $value Property value.
         *
         * @see    PropertiesHandler::$setterPrefix
         * @return void
         * @throws BadMethodCallException If unable to set property value.
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
                $pName = String::ensureIsValidVarName($name);
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
                $mName = String::ensureIsValidVarName($name);
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
         * @param string $name Property name.
         *
         * @return string Same property name, after checks that setter exists.
         * @throws BadMethodCallException If property is not writable or do not exists.
         */
        private function ensurePropertyHasSetter($name)
        {
            $setter = static::$setterPrefix.$this->ensurePropertyExists($name);

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
         * @param string $name Property name.
         *
         * @return string Same property name, after checks that getter exists.
         * @throws BadMethodCallException If property is not readable or do not exists.
         */
        private function ensurePropertyHasGetter($name)
        {
            $getter = static::$getterPrefix.$this->ensurePropertyExists($name);

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
         *
         * @param string $name Property name.
         *
         * @return string
         * @throws BadMethodCallException If property is not valid or has not setter.
         */
        private function getPropertySetter($name)
        {
            $setter = static::$setterPrefix.$this->ensurePropertyHasSetter($name);

            return $setter;
        }


        /**
         * Gets the property getter method name.
         *
         * @param string $name Property name.
         *
         * @return string
         * @throws BadMethodCallException If property is not valid or has not getter.
         */
        private function getPropertyGetter($name)
        {
            $setter = static::$getterPrefix.$this->ensurePropertyHasGetter($name);

            return $setter;
        }
    }
}
