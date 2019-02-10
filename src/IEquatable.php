<?php declare(strict_types=1);
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

/**
 * Provides a generalized method to compare equality of a class instance with a compatible object.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.1.1
 * */
interface IEquatable
{

    /**
     * Indicates whether the specified object is equal to the current instance.
     *
     * @param mixed $other Another object to compare equality.
     *
     * @return bool
     * */
    public function equals($other) : bool;
}
