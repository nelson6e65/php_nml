<?php
# #####################################################
# Clase ObjectBase para PHP 
# ----------------------------------------------
# Autor: 
# 	Nelson Martell (nelson6e65) 
#  	E-Mail: nelson6e65-dev@yahoo.es 
# 	Facebook: http://fb.me/nelson6e65 
#   
#  Copyright © 2014 Nelson Martell 
#
# #####################################################


if (!defined("C_ObjectBase")) {
	define("C_ObjectBase", true);
	
	include('Type.php');
	
	
	class ObjectBase {
		function __construct() { }
		
		/*
		 * Para modificar el funcionamiento de esta función, debe reemplazarse la función ObjectClass::ToString()
		 * */
		final function __toString() {
			$args = null;
			list($args) = func_get_args();	
			return $this->ToString($args);
		}
		
		
		public function ToString(array $args = null) {
			//Implementación por defecto
			return "{". $this->GetType() . "}"; 
			
		}
		
		public final function GetType() {
			return Type::typeof($this);
		}
		
	}
	
}
?>