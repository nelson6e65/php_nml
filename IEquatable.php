<?php
# #####################################################
# Interface «IEquatable» para PHP 
# Versión: 
# ----------------------------------------------
# Autor: 
# 	Nelson Martell (nelson6e65) 
#  	E-Mail: nelson6e65-dev@yahoo.es 
# 	Facebook: http://fb.me/nelson6e65 
#   
#  Copyright © 2015 Nelson Martell 
# 
# #####################################################

$_namespace = "NelsonMartell";
$_class = "IEquatable";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);

	/* 
	 * Representa el número de versión de un elemento o ensamblado. No se puede heredar esta clase.
	 * 
	 * @package  NelsonMartell.Version
	 * @author  Nelson Martell (nelson6e65-dev@yahoo.com)
	 * @license  MIT license
	 * */
	interface IEquatable  {
		
		public function Equals($other);
		
	}
	
endif;
