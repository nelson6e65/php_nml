<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * PHP class «Type»
 * 
 * Copyright © 2013-2015 Nelson Martell (http://fb.me/nelson6e65)
 * 
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 * 
 * @copyright	Copyright © 2013-2015 Nelson Martell 
 * @link		https://github.com/nelson6e65/NelsonMartell
 * @package  	NelsonMartell
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

$_namespace = "NelsonMartell";
$_class = "Type";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);


	include('Object.php');
	
	/* *
	 * Representa al tipo de un objeto PHP.
	 * Posee propiedades y métodos que describen a un tipo.
	 * 
	 * @package  NelsonMartell
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	final class Type extends Object {
		
		/* *
		 * Obtiene el Type del objeto especificado.
		 * 
		 * @param  mixed $obj Objeto al cual se le extraerá su tipo.
		 * */
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
		
		/* *
		 * Gets the name of this Type.
		 * This property is readonly.
		 * 
		 * @var  string
		 * */
		public $Name;
		private $_name;		
		public function get_Name() {
			return $this->_name;
		}
		
		public function GetName() {
			trigger_error(_('To get the name, use Type::Name property instead.'), E_USER_DEPRECATED);
			return $this->get_Name();
		}
		
		/* *
		 * Gets the vars list of this Type.
		 * This property is readonly.
		 * 
		 * @var  array
		 * */
		public $Vars;
		private $_vars;		
		public function get_Vars() {
			return $this->_vars;
		}
		
		public function GetVars() {
			trigger_error(_('To get vars, use Type::Vars property instead.'), E_USER_DEPRECATED);
			return $this->get_Vars();
		}
		
		/* *
		 * Gets the methods list of this Type.
		 * This property is readonly.
		 * 
		 * @var  array
		 * */
		public $Methods;
		private $_methods;
		public function get_Methods(){
			return $this->_methods;
		}
		
		public function GetMethods() {
			trigger_error(_('To get methods, use Type::Methods property instead.'), E_USER_DEPRECATED);
			return $this->get_Methods();
		}
		
		/* *
		 * Determina si este Type es NULL.
		 * 
		 * @return  boolean True if this type is null; other case, False.
		 * */
		public function IsNull() {
			if ($this->Name == 'NULL' || $this->Name == 'null') {
				return true;
			}
			
			return false;			
		}
		
		/* *
		 * Determina si este Type es una clase personalizada.
		 * 
		 * @return  boolean  True, if this Type is a custom class; another case, False.
		 * */
		public function IsCustom() {
			

			switch($this->Name){
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
		
		/* *
		 * Determina si este Type es de tipo valor.
		 * 
		 * @return  boolean
		 * */
		public function IsValueType() {
			switch($this->Name){
				case 'string':
				case 'integer':
				case 'double':
				case 'boolean':
				case 'array':
					return true;
				default:
					return false;
			}
		}
		
		/* *
		 * Determina si este Type es de tipo referencia.
		 * 
		 * @return  boolean
		 * */
		public function IsReferenceType() {
			return !IsValueType();
		}

		/* *
		 * Convierte la instancia actual en su representación en cadena.
		 * 
		 * @return  string
		 * */
		public function ToString() {
			$s = $this->Name;
			
			if ($this->IsCustom()) {
				$s = sprintf("object (%s)", $s);
			}
			
			return $s;
		}
		
	}
	
	/* *
	 * Obtiene el tipo del objeto especificado. 
	 * Es un alias para el constructor de Type.
	 * 
	 * @param   mixed $obj Objeto al cual se le extraerá su tipo.
	 * @return  Type
	 * */
	function typeof($obj) {
		return new Type($obj);
	}
	
endif;
