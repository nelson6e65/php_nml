<?php

/**
 * PHP: Nelson Martell Library polyfill file
 *
 * Copyright © 2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 * @copyright 2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 **/

if (\PHP_VERSION_ID < 80000) {
    interface Stringable
    {
        /**
         * @return string
         */
        public function __toString();
    }
}
