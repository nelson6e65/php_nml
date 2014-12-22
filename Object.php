<?php
# #####################################################
# Clase Object para PHP 
# ----------------------------------------------
# Autor: 
# 	Nelson Martell (nelson6e65) 
#  	E-Mail: nelson6e65-dev@yahoo.es 
# 	Facebook: http://fb.me/nelson6e65 
#   
#  Copyright © 2014 Nelson Martell 
#
# #####################################################


if (!defined("C_Object")) {
	define("C_Object", true);
	
	include('Type.php');
	
	/*
	 * 
	 * 
	 * 
	 * @example  Para usar los getter y setter de los atributos como propiedades, el atributo debe ser privado
	 * y su nombre tipo cammel, iniciando con $_, y su propiedad para get/set debe iniciar en Mayúscula,
	 * sin '_'. Ejemplo: 
	 * 
	 * private $_nombre = ''; //Atributo
	 * public $Nombre; //Propiedad para acceder a $_nombre
	 * 
	 * Luego, las respectivas funciones siguiendo el formato "get_" o "set_", seguido del nombre de la propiedad.
	 * 
	 * public function get_Nombre() {
	 * 		return $this->_nombre;
	 * }
	 * 
	 * public function set_Nombre(string $value) {
	 * 		// Validaciones
	 * 		$this->_nombre = $value;
	 * }
	 * 
	 * Además, en el constructor debe tener una línea como ésta:
	 * 	parent::__construct();
	 * ...
	 * 	unset($this->Nombre);
	 * ...
 	 * */
	class Object {
		function __construct() { 
			
		}
		
		/*
		 * Obtiene el valor de una propiedad según el modelo: 'get_' + $name + '()'
		 * 
		 * */
		function __get($name) {
			$getter = 'get_' . $name;
			
			if (method_exists($this, $getter)) {
				return $this->$getter();
			}
			else {
				throw new BadMethodCallException("There is not getter for " . $name . " property.");
			}
		}
		
		/*
		 * Establece el valor de una propiedad según el modelo: 'set_' + $name + '(' + $value + ')'
		 * 
		 * */
		function __set($name, $value) {
			//var_dump($value);
			$setter = 'set_' . $name;
			
			if (method_exists($this, $setter)) {
				$this->$setter($value);
			}
			else {
				throw new BadMethodCallException("There is not setter for " . $name . " property.");
			}
		}
		
		
		
		
		/*
		 * Para modificar el funcionamiento de esta función, debe reemplazarse la función ObjectClass::ToString()
		 * */
		final function __toString() {			
			//$args = null;
			//list($args) = func_get_args();
			return $this->ToString();
		}
		
		
		public function ToString($format = 'g') {
			//Implementación por defecto
			//var_dump($format);
			return "{". $this->GetType() . "}"; 
			
		}
		
		public final function GetType() {
			return Type::typeof($this);
		}
		
		
		
		
	}
	
}
?>