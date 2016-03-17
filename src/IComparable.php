<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Interface definition:  [NelsonMartell]  IComparable
 *
 * Copyright © 2015-2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.3.2
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    /**
     * Provee métodos para comparar posición relativa entre objetos del mismo
     * tipo, o compatibles.
     *
     * @author Nelson Martell <nelson6e65-dev@yahoo.es>
     * */
    interface IComparable
    {

        /**
         * Determina la posición relativa del objeto especificado con respecto a
         * esta instancia.
         *
         * @param mixed $other Objeto con el cuál comparar posición relativa.
         *
         * @return integer Si es igual, `0` (cero); si es mayor, un número
         *   positivo mayor a `0` (cero); y si es menor, un número negativo.
         * @see    compare
         * */
        public function compareTo($other);

        /**
         * Determina la posición relativa del objeto de la derecha con respecto
         * al de la izquierda.
         * Puede usarse como segundo argumento en la función de ordenamiento de
         * arrays 'usort'.
         *
         * @param mixed $left  Objeto de la izquierda
         * @param mixed $right Objeto de la derecha
         *
         * @return integer Si son iguales, `0` (cero); si el derecho es el mayor
         *   al izquierdo, un número positivo mayor a `0` (cero); y, en caso
         *   contrario, si el izquierdo es el mayor, un número negativo.
         * @see    usort
         * @see    IComparable::compareTo
         * */
        public static function compare($left, $right);
    }
}
