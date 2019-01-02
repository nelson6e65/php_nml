<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Compatibility alias for `NelsonMartell\Extensions\Text` class in PHP <= 7.0 as `String`.
 *
 * Copyright © 2015-2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

use NelsonMartell\Extensions\Text;

if (PHP_VERSION_ID < 70000) {
    class_alias(Text::class, 'NelsonMartell\Extensions\String');
}
