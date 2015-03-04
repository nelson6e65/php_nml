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
use NelsonMartell\Extensions\String;

define('NML_GETTEXT_DOMAIN', 'nml');

/**
 * Busca un mensaje único traducido en el dominio 'nml'.
 * El mensaje puede contener cadenas de formato.
 *
 *
 * @param  string  $message  Mensaje con formato que se va a buscar.
 * @param  array|mixed  $args  Un objeto, una lista de objetos o múltiples argumentos que se van a
 *     incluir en las cadenas de formato del mensaje.
 * @return  string
 * @see  dgettext
 * @see  String::Format
 * */
function nml_msg($message, $args = null) {
	$s = String::Format($message, array_slice(func_get_args(), 1));

	return dgettext(NML_GETTEXT_DOMAIN, $s);
}


/**
 * Busca un mensaje único, en singular y plural, traducido en el dominio 'nml'.
 * El mensaje puede contener cadenas de formato.
 *
 * @param  string  $singular  Mensaje con formato que se va a buscar cuando $n es uno (1).
 * @param  string  $plural  Mensaje con formato que se va a buscar cuando $n es distinto a (1).
 * @param  integer  $n  Cantidad
 * @param  array|mixed  $args  Un objeto, una lista de objetos o múltiples argumentos que se van a
 *     incluir en las cadenas de formato del mensaje.
 * @return  string
 * @see  dngettext
 * @see  String::Format
 * */
function nml_nmsg($singular, $plural, $n, $args = null) {
	$s = String::Format($singular, array_slice(func_get_args(), 1));
	$p = String::Format($plural, array_slice(func_get_args(), 1));

	return dngettext(NML_GETTEXT_DOMAIN, $s, $p, $n);
}

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
