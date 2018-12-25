<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Interface definition
 *
 * Copyright © 2016-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.6.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use JsonSerializable;

/**
 * Provides methods to convert objets into JSON string.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.6.1
 * */
interface IConvertibleToJson extends IConvertibleToString, JsonSerializable
{
    /**
     * Gets the JSON representation of this instance.
     *
     * @return string
     */
    public function toJson();
}
