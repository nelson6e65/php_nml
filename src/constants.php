<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Global constants definitions.
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright © 2015 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.5.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

/**
 * Gettext domain for NML messages.
 * Only for internal usage.
 *
 * @constant string
 * @since v0.4.5
 */
define('NML_GETTEXT_DOMAIN', 'nml');


/**
 * Corrent 'stable' version of `PHP: Nelson Martell Library`.
 * Can be parsed into a `NelsonMartell\Version` object. ;)
 *
 * @constant string
 * @since v0.4.4
 */
define('NML_VERSION', '0.4.6');


// #############################################################################
// If `CODE_ANALYSIS` constant is defined, some NML functions/methods will throw
// notices, warnings and recommendations about its usage. This is useful in
// order to debugging your code.
// Is unactive by default. IT MUST be defined in your bootstrap app code.
//
// define('CODE_ANALYSIS', true);
//
// #############################################################################
