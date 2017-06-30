<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Interface definition
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

/**
 * Provee métodos para comparar posición relativa entre objetos.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @see IComparable
 * */
interface IComparer
{
    /**
     * Compara dos objetos y devuelve un valor que indica si uno es menor, igual o mayor que el otro.
     *
     * Puede usarse como segundo argumento en la función de ordenamiento de arrays ``usort()``.
     *
     * @param mixed $left  Objeto al que se le va a determinar la posición relativa.
     * @param mixed $right Objeto con el cuál se va a comparar posición relativa del de la izquierda.
     *
     * @return integer|null
     *   Debe devolver:
     *   - ``= 0`` si $left se considera equivalente a $right;
     *   - ``> 0`` si $left se considera mayor a $right;
     *   - ``< 0`` si $left se considera menor a $right.
     *   - ``null`` si no se pueden comparar entre sí. (Al usar ``usort()`` se considerarán equivalentes)
     * @see \usort()
     * @see IComparable::compareTo()
     * */
    public static function compare($left, $right);
}
