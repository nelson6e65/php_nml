<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2014-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2014-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use NelsonMartell\Extensions\Arrays;

/**
 * Base class that encapsulates strict properties and other basic features.
 *
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.1.1
 * @see    PropertiesHandler
 * */
class StrictObject implements IComparer, IStrictPropertiesContainer, IConvertibleToString
{
    use PropertiesHandler;

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Convierte esta instancia en su representación de cadena.
     * Para modificar el funcionamiento de esta función, debe reemplazarse
     * la función ObjectClass::toString()
     *
     * @return string
     * @see    StrictObject::toString()
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
     * @return string
     * */
    public function toString()
    {
        $type = typeof($this);

        if (defined('CODE_ANALYSIS')) {
            if ($type->name != 'NelsonMartell\StrictObject') {
                $args = [
                    'access'     => 'public',
                    'base_class' => __CLASS__,
                    'class'      => $type->name,
                    'function'   => __FUNCTION__,
                ];

                $msg = msg('Using default "{base_class}::{function}" ({access}) method.', $args);
                $msg .= msg(
                    ' You can replace (override) its behavior by creating "{class}::{function}" ({access}) method.',
                    $args
                );

                trigger_error($msg, E_USER_NOTICE);
            }
        }

        return '{ '.$type.' }';
    }

    /**
     * Indicates whether the specified object is equal to the current instance.
     *
     * @param mixed $other Another object to compare equality.
     *
     * @return bool Retuns default behaviour of `==`. ***This method must be overridden***.
     * */
    public function equals($other)
    {
        if (defined('CODE_ANALYSIS')) {
            if ($this instanceof IEquatable) {
                $type = typeof($this);

                $args = [
                    'access'     => 'public',
                    'base_class' => __CLASS__,
                    'class'      => $type->name,
                    'function'   => __FUNCTION__,
                ];

                $msg = msg(
                    'You implemented IEquatable, but using default "{base_class}::{function}" ({access}) method.',
                    $args
                );

                $msg .= msg(
                    ' You can replace (override) its behavior by creating "{class}::{function}" ({access}) method.',
                    $args
                );

                trigger_error($msg, E_USER_NOTICE);
            }
        }

        return $this == $other;
    }

    /**
     * Determina la posición relativa del objeto de la izquierda con respecto al de la derecha.
     *
     * Compatible with, strings, integers, boolean, arrays and classes implementing ``IComparable`` interface.
     *
     * Puede usarse como segundo argumento en la función de ordenamiento de
     * arrays 'usort'.
     *
     * Notes:
     * - Comparison is made in natural way if they are of the same type. If not, is used the PHP standard
     * comparison.
     * - If ``$left`` and ``$right`` are arrays, comparison is made by first by 'key' (as strings) and then by
     *   'values' (using this method recursively).
     *
     * # Override
     * You can override this method to implement a contextual sorting behaviour for ``usort()`` function.
     * If you only need to compare instances of your class with other objects, implement
     * ``NelsonMartell\IComparable`` instead.
     *
     * @param mixed $left  Left object.
     * @param mixed $right Right object.
     *
     * @return int|null
     *   Returns:
     *   - ``= 0`` if $left is considered equivalent to $other;
     *   - ``> 0`` if $left is considered greater than $other;
     *   - ``< 0`` if $left is considered less than $other;
     *   - ``null`` if $left can't be compared to $other .
     * @see IComparer::compare()
     * @see IComparable::compareTo()
     * @see \strnatcmp()
     * @see \usort()
     * */
    public static function compare($left, $right)
    {
        $r = null;

        if ($left instanceof IComparable) {
            $r = $left->compareTo($right);
        } elseif ($right instanceof IComparable) {
            $r = $right->compareTo($left);

            if ($r !== null) {
                $r *= -1; // Invert result
            }
        } else {
            $ltype = typeof($left);
            $rtype = typeof($right);

            // If they are of the same type.
            if ($ltype->name === $rtype->name) {
                switch ($ltype->name) {
                    case 'string':
                        $r = strnatcmp($left, $right);
                        break;

                    case 'boolean':
                        $r = (int) $left - (int) $right;
                        break;

                    case 'integer':
                        $r = $left - $right;
                        break;

                    case 'float':
                    case 'double':
                        $r = (int) ceil($left - $right);
                        break;

                    case 'array':
                        $r = Arrays::compare($left, $right);
                        break;

                    default:
                        if ($left == $right) {
                            $r = 0;
                        } else {
                            $r = ($left > $right) ? +1 : -1;
                        }
                }
            } else {
                if ($left == $right) {
                    $r = 0;
                } elseif ($left > $right) {
                    $r = 1;
                } elseif ($left < $right) {
                    $r = -1;
                } else {
                    // If can't determinate, retuns null
                    $r = null;
                }
            }
        }

        return $r;
    }
}
