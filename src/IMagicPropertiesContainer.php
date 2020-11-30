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
 * @copyright 2016-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

/**
 * Mark a class that defines (some of) its properties as DocBlock by using `@property`, `@property-read`
 * or `@property-write` tags.
 *
 * {@see PropertiesHandler} trait will search for property definition in class DocBlock comment. They must be valid,
 * containing at least the type and name: `@<property|property-read|property-write> <types> <name>`.
 *
 * **Examples:**
 *
 * This will be detected:
 *
 * ```php
 * // ...
 * // * @property-write string  $name  Some description
 * // * @property-read float    $age   Another description
 * // * @property int[]|float[] $items
 * ```
 *
 * This will not be detected:
 *
 * ```php
 * // ...
 * // * @property int| string   $invalidTypesSeparation
 * // * @property int|string    $ invalid name
 * ```
 *
 * @see PropertiesHandler
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 1.0.0
 * */
interface IMagicPropertiesContainer
{
}
