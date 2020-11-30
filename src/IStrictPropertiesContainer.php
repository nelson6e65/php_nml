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
 * Mark a class as implementing strict properties only.
 *
 * All classes using ``PropertiesHandler`` trait should be marked with this interface.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @see PropertiesHandler
 * @since 0.6.0
 * */
interface IStrictPropertiesContainer
{
    /**
     * Gets the value of specified property.
     *
     * @param string $name Property name.
     *
     * @return mixed Property value.
     */
    public function __get($name);

    /**
     * Sets the value of specified property.
     *
     * @param string $name  Property name.
     * @param mixed  $value Property value.
     * @return void
     */
    public function __set($name, $value);
}
