<?php
/**
 * PHP interface «IComparable»
 *
 * Copyright © 2015 Nelson Martell (http://fb.me/nelson6e65)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright © 2014, 2015 Nelson Martell
 * @link		http://nelson6e65.github.io/php_nml/
 * @package  	NelsonMartell
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * */

namespace NelsonMartell {

	/**
	 * Provee un método para compara igualdad entre objetos del mismo tipo.
	 *
	 * @package  NelsonMartell
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	interface IComparable  {

		/**
		 * Determina la posición relativa del objeto especificado con respecto a esta instancia.
		 *
		 *
		 * @param   mixed    $other
		 * @return  integer  0, si es igual; >0, si es mayor; <0, si es menor.
		 * */
		public function CompareTo($other);

		/**
		 * Determina la posición relativa del objeto de la derecha con respecto al de la izquierda.
		 * Puede usarse como segundo argumento en la función de ordenamiento de arrays 'usort'.
		 *
		 *
		 * @param   mixed    $left  Objeto de la izquierda
		 * @param   mixed    $right  Objeto de la derecha
		 * @return  integer  0, si ambos son iguales; >0, si $right es mayor a $left; <0, si $left es mayor a $right.
		 * */
		public static function Compare($left, $right);
	}
}
