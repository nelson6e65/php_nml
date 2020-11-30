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
 * Provides extension methods to handle arrays.
 *
 * @since 1.0.0
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
class Arrays implements IComparer
{
    /**
     * Ensures that object given is an `array`. Else, throw an exception.
     *
     * @param mixed $obj Object to validate.
     *
     * @return array Same object given.
     *
     * @throws InvalidArgumentException if object is not an `array`.
     */
    public static function ensureIsArray($obj)
    {
        if (!is_array($obj)) {
            $msg = msg('Provided object must to be an array; "{0}" given.', typeof($obj));
            throw new InvalidArgumentException($msg);
        }

        return $obj;
    }

    /**
     * {@inheritDoc}
     *
     * This methods is specific for the case when one of them are `array`. In other case, will fallback to
     * `Objects::compare()`.` You should use it directly instead of this method as comparation function
     * for `usort()`.
     *
     * @param array|mixed $left
     * @param array|mixed $right
     *
     * @return int|null Returns null if one of them is not an `array`.
     *
     * @since 1.0.0  Move implementation of array comparation from `Objects::compare()`.
     * @see Objects::compare()
     */
    public static function compare($left, $right)
    {
        if (is_array($left)) {
            if (is_array($right)) {
                $r = count($left) - count($right);

                if ($r === 0) {
                    reset($left);
                    reset($right);

                    do {
                        $lKey   = key($left);
                        $lValue = current($left);
                        $rKey   = key($right);
                        $rValue = current($right);

                        $r = Objects::compare((string) $lKey, (string) $rKey);

                        if ($r === 0) {
                            // Recursive call to compare values
                            $r = Objects::compare($lValue, $rValue);
                        }

                        next($left);
                        next($right);
                    } while (key($left) !== null && key($right) !== null && $r === 0);
                }

                return $r;
            } else {
                if (typeof($right)->isCustom()) {
                    return -1;
                } else {
                    return 1;
                }
            }
        } elseif (is_array($right)) {
            $r = static::compare($right, $left);

            if ($r !== null) {
                $r *= -1; // Invert result
            }

            return $r;
        }

        return Objects::compare($left, $right);
    }
}
