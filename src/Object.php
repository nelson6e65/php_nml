<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Compatibility alias for `NelsonMartell\StrictObject` class in PHP <= 7.2 as `Object`.
 *
 * Copyright © 2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

use NelsonMartell\StrictObject;

if (PHP_VERSION_ID < 72000) {
    class_alias(StrictObject::class, 'NelsonMartell\StrictObject');
}
