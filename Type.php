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

	include('Object.php');
	
	
	final class Type extends Object {
		
		function __construct($obj){
			parent::__construct();
			unset($this->Name, $this->Vars, $this->Methods);
			
			$name = gettype($obj);
			$vars = array();
			$methods = array();
			
			if ($name == 'object') {
				$name = get_class($obj);
				if ($name == 'Type') {
					$vars = $obj->Vars;
					$methods = $obj->Methods;
				} else {
					$vars = get_class_vars($name);
					$methods = get_class_methods($obj);
				}
				
			} 
			
			$this->_name = $name;
			$this->_vars = $vars;
			$this->_methods = $methods;
		}
		
		
		private $_name;
		public $Name;
		
		/*
		 * 
		 * @return  string  Nombre del tipo
		 * */
		public function get_Name() {
			return $this->_name;
		}
		
		/*
		 * 
		 * @deprecated Use Name property instead
		 * */
		public function GetName() {
			return $this->get_Name();
		}
		
		private $_vars;
		public $Vars;
		
		public function get_Vars() {
			return $this->_vars;
		}
		
		
		/*
		 * @deprecated Use Vars property instead
		 * */
		public function GetVars() {
			return $this->get_Vars();
		}
		
		
		private $_methods;
		public $Methods;
		
		public function get_Methods(){
			return $this->_methods;
		}
		
		/*
		 * 
		 * @deprecated Use Methods property instead
		 * */
		public function GetMethods() {
			return $this->get_Methods();
		}

		
		/*
		//Genera un Type a partir de otro.
		public function InicializeFromType($type) {
			$this->Name = $type->Name;
			$this->Methods = $type->Methods;
		}
		*/
		
		private static function _isCustom($s) {
			$s = (string) $s;
			
			switch($s){
				case 'string':
				case 'integer':
				case 'double':
				case 'boolean':
				case 'array':
				case 'object':
				case 'NULL':
				case 'null':
					return false;
				default:
					return true;
			}
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
				case 'boolean':
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

		public function ToString() {
			$s = $this->Name;
			
			if ($this->IsCustom()) {
				$s = sprintf("object(%s)", $s);
			}
			
			return $s;
		}
		
		
		 
	}
	
	/*
	 * Obtiene el Type de un objeto. Es un alias para el constructor de Type.
	 * 
	 * @param  mixed Objeto a extraer su tipo
	 * @return  Type Tipo del objeto
	 * */
	function typeof($obj) {
		return new Type($obj);
	}
	
	
}
?>