<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - File to perform manual autoload. For non composer instalation, must be
 *   required at app initialization.
 *
 * Copyright © 2015-2024 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2024 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.3.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'constants.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'functions.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * Custom autoloader for non-composer installations.
 * This function only load classes under 'NelsonMartell' namespace and skips in
 * any other case.
 * If NML class file is not found, throws and exception.
 *
 * Note: If you are using "NelsonMartell" as main namespace in a file that not
 * belongs to NML, you should include it before to load "NML/autoload.php" or,
 * using SPL autoload features, register autoload function for that class(es)
 * using "prepend" argument set to TRUE.
 * Example, if your autoload function is named "no_NML_autoload_function", you
 * can use something like:
 * spl_autoload_register("no_NML_autoload_function", true, TRUE).
 *
 * @param string $class NML class name (full cualified name).
 *
 * @return void
 *
 * phpcs:disable PSR1.Files.SideEffects
 */
function autoloadNelsonMartellLibrary($class)
{
    static $DS = DIRECTORY_SEPARATOR;

    if ($class[0] == '\\') {
        $class = substr($class, 1);
    }

    $classArray = explode('\\', $class);

    if ($classArray[0] == 'NelsonMartell') {
        $classArray[0] = 'src';
    } else {
        // Only checks for NelsonMartell namespace.
        return;
    }

    $path = sprintf('%s' . $DS . '%s', __DIR__, implode($DS, $classArray));

    if (is_file($path . '.php')) {
        $path .= '.php';
    } elseif (is_file($path . '.inc')) {
        $path .= '.inc';
    } else {
        $msg =
            'Unable to auto-load "%s" class in Nelson Martell Library (NML): "%s" file was not found.' .
            ' You can see the API documentation (http://nelson6e65.github.io/php_nml/api) in order to check ' .
            ' availability of all classes/namespaces in NML. Note: If you are using "NelsonMartell" as main namespace' .
            ' in a file that not belongs to NML, you should include it before to load "NML/autoload.php" or,' .
            ' using SPL autoload features, register autoload function for that class(es) using "prepend" argument for' .
            ' spl_autoload_register function set to TRUE.';

        throw new Exception(sprintf(NelsonMartell\msg($msg), $class, $path));
    }

    require_once $path;
}

spl_autoload_register('autoloadNelsonMartellLibrary');
