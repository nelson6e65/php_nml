<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2015-2020 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2020 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.3.2
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

/**
 * Provides a generalized comparison method useful for sorting objects.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.3.2
 * */
interface IComparable
{

    /**
     * Compares the current instance with another object and returns an integer that indicates whether the current
     * instance precedes, follows, or occurs in the same position in the sort order as the other object.
     *
     *
     * @param mixed $other An object to compare with this instance.
     *
     * @return int|null A value that indicates the relative order of the objects being compared. The return value has
     * these meanings:
     *
     * | Value           | Meaning |
     * |:---:|---|
     * Less than zero    | This instance precedes `$other` in the sort order.
     * `0`               | This instance occurs in the same position in the sort order as `$other`.
     * Greater than zero | This instance follows `$other` in the sort order.
     * `null`            | Indeterminated. If `$other` can't be compared with this instance.
     *
     * @see IComparer::compare()
     * */
    public function compareTo($other);
}
