<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * PHP interface «IEquatable»
 *
 * Copyright © 2014, 2015 Nelson Martell (http://fb.me/nelson6e65)
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
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

namespace NelsonMartell {
	$_class = "IEquatable";
	$_constant = implode('_', explode('\\', __NAMESPACE__)) . '_' . $_class;

	if (!defined($_constant)):
		define($_constant, true);

	/*
	 * Representa el número de versión de un elemento o ensamblado. No se puede heredar esta clase.
	 *
	 * @package  NelsonMartell
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	interface IEquatable  {

		public function Equals($other);

	}

	endif;
}