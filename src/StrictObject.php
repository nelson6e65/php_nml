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

use NelsonMartell\Extensions\Text;
use NelsonMartell\Extensions\Arrays;
use NelsonMartell\Extensions\Numbers;

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

                $msg  = msg('Using default "{base_class}::{function}" ({access}) method.', $args);
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
     * Determines the relative position of the object on the left with respect to the one on the right.
     *
     * This method is compatible with core types and other types. You can implement `NelsonMartell\IComparable`
     * in order to improve the beaviout for other classes.
     *
     * This method can be used as sorting function for `usort()` function.
     *
     * **Notes:**
     * - Comparison is made in natural way if they are of the same type. If not, is used the PHP standard
     * comparison.
     * - If ``$left`` and ``$right`` are arrays, comparison is made by first by 'key' (as strings) and then by
     *   'values' (using this method recursively).
     *
     * **Override:**
     * You can override this method to implement a contextual sorting behaviour for `usort()` function.
     * If you only need to compare instances of your class with other objects, implement `NelsonMartell\IComparable`
     * instead.
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
     *
     * @see \strnatcmp()
     * @see \usort()
     * @see Arrays::compare()
     * @see IComparable
     * @see IComparable::compareTo()
     * @see IComparer::compare()
     * @see Numbers::compare()
     * @see Text::compare()
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

            if (typeof((bool) true)->isIn($left, $right)) {
            // Boolean compare -----------------------------------------
                if (typeof((bool) true)->is($left, $right)) {
                    $r = (int) $left - (int) $right;
                } else {
                    $r = null;
                }
            } elseif (typeof((int) 0)->isIn($left, $right) || typeof((float) 0)->isIn($left, $right)) {
            // Numeric compare -----------------------------------------
                $r = Numbers::compare($left, $right);
            } elseif (typeof((string) '')->isIn($left, $right)) {
            // String compare ------------------------------------------
                $r = Text::compare($left, $right);
            } elseif (typeof((array) [])->isIn($left, $right)) {
            // Array compare -------------------------------------------
                $r = Arrays::compare($left, $right);
            } else {
                if ($ltype->isCustom()) {
                    if ($rtype->isCustom()) {
                        if ($left == $right) {
                            $r = 0;
                        } elseif ($ltype->equals($rtype)) {
                            $r = ($left > $right) ? +1 : -1;
                        } else {
                            $r = null;
                        }
                    } else {
                        $r = 1;
                    }
                } elseif ($rtype->isCustom()) {
                    $r = -1;
                } else {
                    $r = null;
                }
            }
        }

        return $r;
    }
}
