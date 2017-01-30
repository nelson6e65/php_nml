<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Global functions definition for NML.
 *
 * Copyright © 2016-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use NelsonMartell\Extensions\String;

/**
 * Busca un mensaje único traducido en el dominio 'nml'.
 * El mensaje puede contener cadenas de formato.
 *
 * @param string      $message Mensaje con formato que se va a buscar.
 * @param array|mixed $args    Un objeto, una lista de objetos o múltiples
 *   argumentos que se van a incluir en las cadenas de formato del mensaje.
 *
 * @return string
 * @since v0.6.0
 * @see \dgettext()
 * */
function msg($message, $args = null)
{
    $translated = \dgettext(NML_GETTEXT_DOMAIN, $message);

    if (\func_num_args() > 2) {
        $args = \array_slice(func_get_args(), 1);
    }

    return String::format($translated, $args);
}


/**
 * Busca un mensaje único, en singular y plural, traducido en el dominio 'nml'.
 * El mensaje puede contener cadenas de formato.
 *
 * @param string      $singular Mensaje con formato que se va a buscar cuando $n
 *   es uno (1).
 * @param string      $plural   Mensaje con formato que se va a buscar cuando $n
 *   es distinto a (1).
 * @param integer     $n        Cantidad
 * @param array|mixed $args     Un objeto, una lista de objetos o múltiples
 *   argumentos que se van a incluir en las cadenas de formato del mensaje.
 *
 * @return string
 * @since v0.6.0
 * @see \dngettext()
 * */
function nmsg($singular, $plural, $n, $args = null)
{
    $translated = \dngettext(NML_GETTEXT_DOMAIN, $singular, $plural, $n);

    if (\func_num_args() > 4) {
        $args = \array_slice(func_get_args(), 3);
    }

    return String::format($translated, $args);
}


/**
 * Obtiene el tipo del objeto especificado.
 * Es un alias para el constructor de la clase Type.
 *
 * @param mixed $obj Objeto al cual se le extraerá su tipo.
 *
 * @return Type
 * @since v0.6.0
 * */
function typeof($obj)
{
    return new Type($obj);
}
