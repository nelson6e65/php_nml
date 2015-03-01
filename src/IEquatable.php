<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Interface definition:  [NelsonMartell]  IEquatable
 *
 * Copyright © 2014, 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2014, 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.1.1
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

	/**
	 * Provee un método para compara igualdad entre objetos del mismo tipo.
	 *
	 * @author  Nelson Martell (nelson6e65-dev@yahoo.es)
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
