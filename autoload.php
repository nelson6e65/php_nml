<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - File to perform manual autoload. For non composer instalation, must be
 *   required at app initialization.
 *
 * Copyright © 2015-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.3.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

require_once __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'constants.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'functions.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'autoloader.php';

spl_autoload_register('autoload_NML');

// require_once('vendor/autoload.php');
