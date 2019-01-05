<?php declare(strict_types=1);
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Global functions definition for NML.
 *
 * Copyright © 2016-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use InvalidArgumentException;

use NelsonMartell\Extensions\Text;

/**
 * Busca un mensaje único traducido en el dominio 'nml'.
 * El mensaje puede contener cadenas de formato.
 *
 * @param string      $message Mensaje con formato que se va a buscar.
 * @param array|mixed $args    Lista de objetos que se van a incluir en las cadenas de formato del mensaje.
 *
 * @return string
 * @since 0.6.0
 * @see \dgettext()
 * */
function msg(string $message, ...$args) : string
{
    $translated = \dgettext(NML_GETTEXT_DOMAIN, $message);

    $data = $args;

    if (count($args) === 1 && is_array($args[0])) {
        $data = $args[0];
    }

    return Text::format($translated, $data);
}


/**
 * Busca un mensaje único, en singular y plural, traducido en el dominio 'nml'.
 * El mensaje puede contener cadenas de formato.
 *
 * @param string      $singular Mensaje con formato que se va a buscar cuando $n
 *   es uno (1).
 * @param string      $plural   Mensaje con formato que se va a buscar cuando $n
 *   es distinto a (1).
 * @param int         $n        Cantidad
 * @param array|mixed $args     Lista de objetos que se van a incluir en las cadenas de formato del mensaje.
 *
 * @return string
 * @since 0.6.0
 * @see \dngettext()
 * */
function nmsg(string $singular, string $plural, int $n, ...$args) : string
{
    $translated = \dngettext(NML_GETTEXT_DOMAIN, $singular, $plural, $n);

    $data = $args;

    if (count($args) === 1 && is_array($args[0])) {
        $data = $args[0];
    }

    return Text::format($translated, $data);
}


/**
 * Obtiene el tipo del objeto especificado.
 * Es un alias para el constructor de la clase Type.
 *
 * @param string|mixed  $obj
 * @param bool          $searchName
 *
 * @return Type
 * @throws InvalidArgumentException
 *
 * @since 0.6.0
 *
 * @see Type::__construct()
 * */
function typeof($obj, bool $searchName = false) : Type
{
    return new Type($obj, $searchName);
}
