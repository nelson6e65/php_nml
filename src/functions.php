<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Global functions definition for NML.
 * - Global constant definition:  NML_GETTEXT_DOMAIN
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.4.5
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

use NelsonMartell\Type;

if (!function_exists('typeof')) {

	/**
	 * Obtiene el tipo del objeto especificado.
	 * Es un alias para el constructor de la clase Type.
	 *
	 *
	 * @param   mixed  $obj Objeto al cual se le extraerá su tipo.
	 * @return  Type
	 * @see  Type::__construct
	 * */
	function typeof($obj) {
		return new Type($obj);
	}
}
