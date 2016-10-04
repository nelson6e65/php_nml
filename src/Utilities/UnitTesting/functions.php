<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Aliases of global internal functions in order to make them availables in this namespace.
 *
 * Copyright © 2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Utilities\UnitTesting;

/**
 * @see \NelsonMartell\msg()
 * @internal
 */
function msg($message, $args = null)
{
    return \NelsonMartell\msg($message, $args);
}

/**
 * @see \NelsonMartell\nmsg()
 * @internal
 */
function nmsg($singular, $plural, $n, $args = null)
{
    return \NelsonMartell\nmsg($singular, $plural, $n, $args);
}

/**
 * @see \NelsonMartell\typeof()
 * @internal
 */
function typeof($obj)
{
    return \NelsonMartell\typeof($obj);
}
