<?php
/**
 * PHP class «Type»
 *
 * Copyright © 2013-2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright © 2013-2015 Nelson Martell
 * @link		http://nelson6e65.github.io/php_nml/
 * @package  	NelsonMartell
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * */

namespace NelsonMartell {
	use \ReflectionClass;
	use \ReflectionProperty;
	use \ReflectionMethod;

	/**
	 * Represents a PHP object type, and provides some properties and methods to describe some info
	 * about itself.
	 *
	 * @package  NelsonMartell
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	final class Type extends Object {

		/**
		 * Gets the type of specified $obj and collect some info about itself.
		 *
		 * @param  mixed  $obj  Target object.
		 * */
		function __construct($obj) {
			parent::__construct();
			unset($this->Namespace, $this->Name, $this->ShortName, $this->Vars, $this->Methods);

			$name = gettype($obj);
			$shortname = null;
			$namespace = null;
			$vars = null;
			$methods = null;
			$ref = null;

			switch ($name) {
				case 'object':
					$ref = new ReflectionClass($obj);
					$name = $ref->getName();
					$shortName = $ref->getShortName();
					$namespace = $ref->getNamespaceName();
					break;

				case 'resource':
					$shortName = get_resource_type($obj);
					$name = 'resource: ' . $shortName;
					$vars = [];
					$methods = [];
					break;

				default:
					$shortName = $name;
					$vars = [];
					$methods = [];
			}

			$this->_name = $name;
			$this->_shortName = $shortName;
			$this->_namespace = $namespace;
			$this->_vars = $vars;
			$this->_methods = $methods;
			$this->_reflectionObject = $ref;
		}

		private $_reflectionObject = null;

		/**
		 * Gets the name of this Type.
		 * This property is read-only.
		 *
		 * @var  string
		 * */
		public $Name;
		private $_name;

		/**
		 * Getter for Type::Name property.
		 *
		 * @return  string
		 * */
		public function get_Name() {
			return $this->_name;
		}

		/**
		 * Gets the abbreviated name of class, in other words, without the namespace.
		 * This property is read-only.
		 *
		 * @var  string
		 * */
		public $ShortName;
		private $_shortName = null;

		/**
		 * Getter for Type::ShortName property.
		 *
		 * @return  string
		 * @see  Type::ShortName
		 * */
		public function get_ShortName() {
			return $this->_shortName;
		}

		/**
		 * Gets the namespace name of this class.
		 * If this Type is not a class, this property is set to `NULL`.
		 * This property is read-only.
		 *
		 * @var  string|NULL
		 * */
		public $Namespace;
		private $_namespace;

		/**
		 * Getter for Type::Namespace property.
		 *
		 * @return  string|NULL
		 * @see  Type::Namespace
		 * */
		public function get_Namespace() {
			return $this->_namespace;
		}

		/**
		 * Gets the public|protected properties (ReflectionProperty) of this Type.
		 * This property is read-only.
		 *
		 *
		 * @var  array
		 * */
		public $Vars;
		private $_vars = null;
		public function get_Vars() {
			if ($this->_vars == NULL) {
				$this->_vars = $this->_reflectionObject->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
			}
			return $this->_vars;
		}

		/**
		 * Gets the public|protected methods (ReflectionMethod) of this Type.
		 * This property is read-only.
		 *
		 *
		 * @var  array
		 * */
		public $Methods;
		private $_methods = null;
		public function get_Methods() {
			if ($this->_methods == null) {
				$this->_methods = $this->_reflectionObject->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED);
			}
			return $this->_methods;
		}

		/**
		 * Determina si este Type es NULL.
		 *
		 *
		 * @return  boolean True if this type is null; other case, False.
		 * */
		public function IsNull() {
			if ($this->Name == 'NULL' || $this->Name == 'null') {
				return true;
			}

			return false;
		}

		/**
		 * Determina si este Type NO es NULL.
		 *
		 *
		 * @return  boolean True if this type is NOT null; other case, False.
		 * */
		public function IsNotNull() {
			return !$this->IsNull();
		}


		/**
		 * Determina si este Type es una clase personalizada.
		 *
		 *
		 * @return  boolean  True, if this Type is a custom class; another case, False.
		 * */
		public function IsCustom() {
			switch ($this->Name) {
				case 'boolean':
				case 'integer':
				case 'double':
				case 'string':
				case 'array':
				case 'NULL':
				case 'null':
					return false;
				default:
					return true;
			}
		}

		/**
		 * Determinate if this type is scalar.
		 *
		 * @return  boolean
		 * @see  is_scalar()
		 * */
		public function IsScalar() {
			$r = false;

			switch ($this->Name) {
				case 'boolean':
				case 'integer':
				case 'double':
				case 'string':
					$r = true;
					break;

				default:
					$r = false;
			}

			return $r;
		}

		/**
		 * Determina si este Type es de tipo valor.
		 *
		 *
		 * @return  boolean
		 * @deprecated  Use more precise method: Type::IsScalar, which excludes `array`.
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

		/**
		 * Determina si este Type es de tipo referencia.
		 *
		 *
		 * @return  boolean
		 * */
		public function IsReferenceType() {
			return !IsValueType();
		}

		/**
		 * Convierte la instancia actual en su representación en cadena.
		 *
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

		/**
		 * Obtiene el tipo del objeto especificado.
		 * Es un alias para el constructor de Type.
		 *
		 *
		 * @return  Type
		 * */
		public static function typeof($obj) {
			return new static($obj);
		}

	}
}

namespace {
	use NelsonMartell\Type;

	if (!function_exists('typeof')) {
		/**
		 * Obtiene el tipo del objeto especificado.
		 * Accede de manera global a la función Type::typeof.
		 *
		 *
		 * @param   mixed $obj Objeto al cual se le extraerá su tipo.
		 * @return  Type
		 * */
		function typeof($obj) {
			return Type::typeof($obj);
		}
	}
}
