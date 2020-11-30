<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

/**
 * Exposes a method that compares two objects
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @see IComparable
 * @since 0.6.0
 * */
interface IComparer
{
    /**
     * Compares two objects and returns a value indicating whether one is less than, equal to, or greater than the
     * other.
     *
     * Can be used as 2nd parameter of `usort()` function.
     *
     * @param mixed $left  Object to which the relative position will be determined.
     * @param mixed $right The second object to compare.
     *
     * @return int|null A value that indicates the relative order of the objects being compared. The return value has
     * these meanings:
     *
     * | Value           | Meaning |
     * |:---:|---|
     * Less than zero    | This `$left` precedes `$right` in the sort order.
     * `0`               | `$left` occurs in the same position in the sort order as `$right`.
     * Greater than zero | This instance follows `$other` in the sort order.
     * `null`            | Indeterminated. If `$left` and `$right` can't be compared to each other.
     *
     * @see \usort()
     * @see IComparable::compareTo()
     * */
    public static function compare($left, $right);
}
