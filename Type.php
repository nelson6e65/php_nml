<?php
# #####################################################
# Clase Type para PHP 
# 
# ----------------------------------------------
# Autor: 
# 	Nelson Martell (nelson6e65) 
#  	E-Mail: nelson6e65-dev@yahoo.es 
# 	Facebook: http://fb.me/nelson6e65 
#   
#  Copyright © 2013, 2015 Nelson Martell 
#
# #####################################################

#ifndef C_Type
	#define C_Type		
#endif
if (!defined("C_Type")) {		
	define("C_Type", true);

	
	
	final class Type {
		public $Name;
		
		function __construct($nombre){
			if (is_string($nombre)) {
				$this->Name = $nombre;
			} else {
				$this->InicializeFromType(typeof($nombre));
			}
		}
		
		///Obtiene el nombre del tipo
		public function GetName() {
			return $this->Name;
		}
		
		public $Vars;
		public function GetVars() {
			return $this->Vars;
		}
				
		public $Methods;
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

		public final function __toString() {
			$aux = "t";
			if ($this->IsCustom())
				$aux = "T";
			return $aux . ":" . $this->Name;
		}
	}
	
	/*
	 * Obtiene el Type de un objeto
	 * @param  mixed Objeto a extraer su tipo
	 * @return  Type Tipo del objeto
	 * */
	function typeof($obj) {
		$t = new Type(gettype($obj));				
		
		if ($t->Name == 'object') {
			$t = new Type(get_class($obj));
			$t->Methods = get_class_methods($obj);
		}
		
		return $t;
	}
	
	
}
?>