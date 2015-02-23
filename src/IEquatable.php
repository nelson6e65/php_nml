<?php
/**
 * PHP interface «IEquatable»
 *
 * Copyright © 2014, 2015 Nelson Martell (http://nelson6e65.github.io)
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
	interface IEquatable  {

		/**
		 * Indica si el objeto especificado es igual a la instancia actual.
		 * 
		 * 
		 * @return  boolean
		 * */
		public function Equals($other);

	}
}
