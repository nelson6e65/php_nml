<?php
# #####################################################
# Clase Type para PHP 
# Versión: 1.0.0.0 (2013-04-19) 
# ----------------------------------------------
# Autor: 
# 	Nelson Martell (nelson6e65) 
#  	E-Mail: nelson6e65-dev@yahoo.es 
# 	Facebook: http://fb.me/nelson6e65 
#   
#  Copyright © 2013 Nelson Martell 
#
# #####################################################

#ifndef C_Type
	#define C_Type		
#endif
if (!defined("C_Type")) {		
	define("C_Type", true);

	
	
	final class Type {
		private $Name;
		
		function __construct($nombre){
			if (is_string($nombre)) {
				$this->Name = $nombre;
			} else {
				$this->InicializeFromType(self::typeof($nombre));
			}
			
			
		}
		///Obtiene el nombre del tipo
		public function GetName() {
			return $this->Name;
		}
		
		private $Vars;
		public function GetVars() {
			return $this->Vars;
		}
				
		private $Methods;
		public function GetMethods() {
			return $this->Methods;
		}

		

		//Genera un Type a partir de otro.
		public function InicializeFromType($type) {
			$this->Name = $type->Name;
			$this->Methods = $type->Methods;
		}

		//Indica si el tipo especificado es una clase definida; es decir, diferente a 'integer', 'double', 'array' y 'object'.
		public function IsCustom() {
			switch($this->Name){
				case 'string':
				case 'integer':
				case 'double':
				case 'array':
				case 'object':
				case 'NULL':
				case 'null':
					return false;
				default:
					return true;
			}
		}
		
		public function IsValueType() {
			switch($this->Name){
				case 'string':
				case 'integer':
				case 'double':
				case 'array':
					return true;
				default:
					return false;
			}
		}
		
		public function IsReferenceType() {
			switch($this->Name){
				case 'string':
				case 'integer':
				case 'double':	
				case 'array':
					return false;
				default:
					return true;
			}
		}


		//Obtiene el tipo de una variable
		public static function typeof($var) {
			$tipo = new Type(gettype($var));				
			
			if ($tipo->Name == 'object') {
				$tipo = new Type(get_class($var));
				$tipo->Methods = get_class_methods($var);
			}
			
			return $tipo;
		}
		
		public function __invoke($x) {
			return Type::typeof($x); //funciona como un alias para typeof, usando: $a = "Soy una cadena"; Type($a); 
		}
		
		public final function __toString() {
			$aux = "t";
			if ($this->IsCustom())
				$aux = "T";
			return $aux . ":" . $this->Name;
		}
	}
}
?>