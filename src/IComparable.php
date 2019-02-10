<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2015-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.3.2
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

/**
 * Provee métodos para comparar posición relativa de instancia.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.3.2
 * */
interface IComparable
{

    /**
     * Determina la posición relativa de esta instancia con respecto al objeto especificado.
     *
     *
     * @param mixed $other Objeto con el cuál se va a comparar posición relativa de esta instancia.
     *
     * @return int|null
     *   Debe devolver:
     *   - ``= 0`` si esta instancia se considera equivalente a $other;
     *   - ``> 0`` si esta instancia se considera mayor a $other;
     *   - ``< 0`` si esta instancia se considera menor a $other.
     *   - ``null`` si esta instancia no se puede comparar a $other.
     *
     * @see IComparer::compare()
     * */
    public function compareTo($other);
}
