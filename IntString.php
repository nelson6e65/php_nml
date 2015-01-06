<?php
# #####################################################
# Clase «IntString» para PHP 
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
$_class = "IntString";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);

	include('Object.php');
	
	/*
	 * Representa un elemento mixto, compuesto por un entero y una cadena unidos (en ese orden).
	 * El método ToString obtiene esa cadena compuesta.
	 * */
	class IntString extends Object implements IEquatable {
		
		function __construct($intValue = 0, $stringValue = '') {
			unset($this->IntValue, $this->StringValue);
			
			$this->_intValue = (int) $intValue;
			$this->_stringValue = (string) $stringValue;			
		}
		
		public static function Parse($parseableString) {
			$s = new IntString();
			
			if (typeof($parseableString) == $s->GetType()) {
				return $parseableString;
			}
			
			
			$s = (string) $parseableString;
			$intValue = (int) $s; 
			
			$stringValue = explode($intValue, $s, 2);
			
			if ($intValue) {
				$stringValue = $stringValue[1];
			} else {
				$stringValue = $stringValue[0];
			}
			
			return new IntString($intValue, $stringValue);
		}
		
		
		private $_intValue = 0;
		private $_stringValue = '';

		public $IntValue;
		public function get_IntValue() {
			return $this->_intValue;
		}
		
		public $StringValue;
		public function get_StringValue() {
			return $this->_stringValue;
		}
		
		public function ToString() {
			return $this->IntValue . $this->StringValue;
		}
		
		public function Equals($other) {
			if ($other instanceof IntString) {
				if ($this->IntValue == $other->IntValue) {
					if ($this->StringValue == $other->StringValue) {
						return true;
					}
				}
			}
			
			return false;
		}
	}

endif;
