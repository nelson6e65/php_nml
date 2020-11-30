<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2020 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2020 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Extensions;

use InvalidArgumentException;
use NelsonMartell\IComparer;
use NelsonMartell\IComparable;
use NelsonMartell\StrictObject;

use function NelsonMartell\msg;
use function NelsonMartell\typeof;

/**
 * Provides extension methods to handle numbers.
 *
 * @since 1.0.0
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
class Objects implements IComparer
{

    /**
     * Determines the relative position of the object on the left with respect to the one on the right.
     *
     * This method is compatible with core types and other types. You can implement `NelsonMartell\IComparable`
     * in order to improve the beaviour for other classes.
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
     *
     * @since 1.0.0 Moved from `StrictObject::compare()`.
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
