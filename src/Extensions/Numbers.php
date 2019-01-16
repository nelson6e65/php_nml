<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */
namespace NelsonMartell\Extensions;

use InvalidArgumentException;

use NelsonMartell\IComparer;
use NelsonMartell\StrictObject;

use function NelsonMartell\msg;
use function NelsonMartell\typeof;

/**
 * Provides extension methods to handle numbers.
 *
 * @since 1.0.0
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
class Numbers implements IComparer
{
    /**
     * Ensures that object given is an integer. Else, thows an exception.
     *
     * @param mixed $obj Object to validate.
     *
     * @return float|int Same object given, but ensured that is a number.
     *
     * @throws InvalidArgumentException if object is not a `int` or `float`.
     */
    public static function ensureIsNumeric($obj)
    {
        if (!is_int($obj) || !is_float($obj) || is_object($obj)) {
            $msg = msg('Provided object must to be an integer or float; "{0}" given.', typeof($obj));
            throw new InvalidArgumentException($msg);
        }

        return $obj;
    }

    /**
     * {@inheritDoc}
     *
     * This methods is specific for the case when one of them are `numeric`. In other case, will fallback to
     * `StrictObject::compare()`.` You should use it directly instead of this method as comparation function
     * for `usort()`.
     *
     * @param int|float|mixed $left
     * @param int|float|mixed $right
     *
     * @return int|null
     *
     * @since 1.0.0
     * @see StrictObject::compare()
     */
    public static function compare($left, $right)
    {
        if (is_numeric($left)) {
            if (is_numeric($right) && !is_nan($right)) {
                $r = $left - $right;

                if ($r > 0) {
                    $r = (int) ceil($r);
                } else {
                    $r = (int) floor($r);
                }

                return $r;
            } elseif ($right === null) {
                return 1;
            } else {
                return -1;
            }
        } elseif (is_numeric($right)) {
            $r = static::compare($right, $left);

            if ($r !== null) {
                $r *= -1;
            }

            return $r;
        }

        return Objects::compare($left, $right);
    }
}
