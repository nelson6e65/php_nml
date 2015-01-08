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
 * @link		https://github.com/nelson6e65/NelsonMartell
 * @package  	NelsonMartell
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

$_namespace = "NelsonMartell";
$_class = "IEquatable";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);

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
