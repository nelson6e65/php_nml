<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  Object
 *
 * Copyright © 2014, 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2014, 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.1.1
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    use \BadMethodCallException;

    /**
     * Clase base de objetos, para encapsular propiedades y otros métodos básicos.
     *
     *
     * @example  Para usar los getter y setter de los atributos como propiedades, el atributo debe
     * ser privado y su nombre tipo cammel, iniciando con $_, y su propiedad para get/set debe
     * iniciar en Mayúscula, sin '_'. Ejemplo:
     *
     * private $_nombre = ''; //Atributo
     * public $Nombre; //Propiedad para acceder a $_nombre
     *
     * Luego, las respectivas funciones siguiendo el formato "get_" o "set_", seguido del nombre de
     * la propiedad.
     *
     * public function getNombre() {
     *         return $this->_nombre;
     * }
     *
     * public function setNombre(string $value) {
     *         // Validaciones
     *         $this->_nombre = $value;
     * }
     *
     * Además, para habilitar esta funcionalidad de propiedades, el constructor debe la siguiente
     * línea:
     *     unset($this->Nombre);
     *
     *
     * @author  Nelson Martell <nelson6e65-dev@yahoo.es>
     * */
    class Object
    {
        use PropertiesHandler;

        public function __construct()
        {
        }

        /**
         * Convierte esta instancia en su representación de cadena.
         * Para modificar el funcionamiento de esta función, debe reemplazarse la función
         * ObjectClass::ToString()
         *
         *
         * @return  string
         * */
        final public function __toString()
        {
            //$args = null;
            //list($args) = func_get_args();
            return $this->toString();
        }

        /**
         * Convierte la instancia actual en su representación de cadena.
         *
         *
         * @return  string
         * */
        public function toString()
        {
            $type = $this->getType();

            if (defined('CODE_ANALYSIS')) {
                if ($type->Name != 'NelsonMartell\Object') {
                    $args = [
                        'access'     => 'public',
                        'base_class' => __CLASS__,
                        'class'      => $type->Name,
                        'function'   => __FUNCTION__,
                    ];

                    $msg = nml_msg('Using default "{base_class}::{function}" ({access}) method.', $args);
                    $msg .= nml_msg(
                        ' You can replace (override) its behavior by creating "{class}::{function}" ({access}) method.',
                        $args
                    );

                    trigger_error($msg, E_USER_NOTICE);
                }
            }

            return '{ '.$type.' }';
        }

        /**
         * Obtiene el tipo del objeto actual.
         *
         *
         * @return  Type
         * */
        final public function getType()
        {
            return typeof($this);
        }

        public function equals($other)
        {
            if (defined('CODE_ANALYSIS')) {
                if ($this instanceof IEquatable) {
                    $type = $this->getType();

                    $args = [
                        'access'     => 'public',
                        'base_class' => __CLASS__,
                        'class'      => $type->Name,
                        'function'   => __FUNCTION__,
                    ];

                    $msg = nml_msg(
                        'You implemented IEquatable, but using default "{base_class}::{function}" ({access}) method.',
                        $args
                    );

                    $msg .= nml_msg(
                        ' You can replace (override) its behavior by creating "{class}::{function}" ({access}) method.',
                        $args
                    );

                    trigger_error($msg, E_USER_NOTICE);
                }
            }

            return $this == $other;
        }

        /**
         * Determina la posición relativa del objeto de la derecha con respecto al de la izquierda.
         * Puede usarse como segundo argumento en la función de ordenamiento de arrays 'usort'.
         *
         *
         * @param   mixed  $left   Objeto de la izquierda
         * @param   mixed  $right  Objeto de la derecha
         * @return  integer  0, si ambos son iguales; >0, si $right es mayor a $left; <0, si $left es mayor a $right.
         * */
        public static function compare($left, $right)
        {
            $r = null;

            if ($left instanceof IComparable) {
                $r = $left->CompareTo($right);
            } else {
                if ($right instanceof IComparable) {
                    $r = $right->CompareTo($left);
                } else {
                    //Si no son miembros de IComparable, se usa por defecto:
                    if ($left == $right) {
                        $r = 0;
                    } else {
                        $r = ($left > $right) ? +1 : -1;
                    }
                }
            }

            return $r;
        }
    }
}
