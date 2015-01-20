<?php
/**
 * PHP class «Object»
 *
 * Copyright © 2014, 2015 Nelson Martell (http://fb.me/nelson6e65)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright © 2014, 2015 Nelson Martell
 * @link		http://nelson6e65.github.io/php_nml/
 * @package  	NelsonMartell
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * */

namespace NelsonMartell {

	$_class = "Object";
	$_constant = implode('_', explode('\\', __NAMESPACE__)) . '_' . $_class;

	if (!defined($_constant)):
		define($_constant, true);

	include('Type.php');
	include('IEquatable.php');

	/**
	 * Clase base de objetos, para encapsular propiedades y otros métodos básicos.
	 *
	 *
	 * @example  Para usar los getter y setter de los atributos como propiedades, el atributo debe
	 * ser privado y su nombre tipo cammel, iniciando con $_, y su propiedad para get/set debe
	 * iniciar en Mayúscula, sin '_'. Ejemplo:
	 *
	 * private $_nombre = ''; //Atributo
	 * public $Nombre; //Propiedad para acceder a $_nombre
	 *
	 * Luego, las respectivas funciones siguiendo el formato "get_" o "set_", seguido del nombre de
	 * la propiedad.
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
	 * Además, para habilitar esta funcionalidad de propiedades, el constructor debe la siguiente
	 * línea:
	 * 	unset($this->Nombre);
	 *
	 *
	 * @package  NelsonMartell
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
 	 * */
	class Object {
		function __construct() {

		}

		/**
		 * Obtiene el valor de una propiedad. Ésta debe definir un método getter, que sigue este
		 * modelo: 'get_' + $name + '()'.
		 * Restringe la obtención de una propiedad no definida dentro de la clase si no posee su
		 * método getter.
		 * 
		 * 
		 * */
		function __get($name) {
			$error = false;

			if (!property_exists($this, $name)) {
				$error = _('Property do not exists') . '.';
			}

			$getter = 'get_' . $name;

			if (!$error) {
				if (!method_exists($this, $getter)) {
					$error = _('Property is write only') . '.'; //?
				}
			}

			if ($error) {
				throw new BadMethodCallException(sprintf(_("Unable to access to '%s' property in '%s' class. Reason: %s"), $name, $this->GetType()->GetName(), $error));
			}

			return $this->$getter();
		}

		/**
		 * Establece el valor de una propiedad según el modelo: 'set_' + $name + '(' + $value + ')'
		 * Restringe la asignación de una propiedad no definida dentro de la clase si no posee su
		 * método setter.
		 * 
		 * 
		 * */
		function __set($name, $value) {
			$error = false;

			if (!property_exists($this, $name)) {
				$error = _('Property do not exists') . '.';
			}

			$setter = 'set_' . $name;

			if (!$error) {
				if (!method_exists($this, $setter)) {
					$error = _('Property is read only') . '.'; //La propiedad existe, pero no tiene establecido el método setter.
				}
			}

			if ($error) {
				throw new BadMethodCallException(sprintf(_("Unable to assign '%s' property in '%s' class. Reason: %s"), $name, $this->GetType()->Name, $error));
			}

			$this->$setter($value);
		}




		/**
		 * Convierte esta instancia en su representación de cadena.
		 * Para modificar el funcionamiento de esta función, debe reemplazarse la función
		 * ObjectClass::ToString()
		 * 
		 * 
		 * @return  string
		 * */
		final function __toString() {
			//$args = null;
			//list($args) = func_get_args();
			return $this->ToString();
		}
		
		/**
		 * Convierte la instancia actual en su representación de cadena.
		 * 
		 * 
		 * @return  string
		 * */
		public function ToString() {
			$t = $this->GetType();

			if ($t->Name != 'Object') {
				trigger_error(sprintf(_('Using default Object::ToString() method. You must override it, creating %s::ToString() public method.'), $t->Name), E_USER_NOTICE);
			}

			return '{ ' . $this->GetType() . ' }';

		}

		/**
		 * Obtiene el tipo del objeto actual.
		 * 
		 * 
		 * @return  Type
		 * */
		public final function GetType() {
			return typeof($this);
		}

		public function Equals($other) {
			if ($this instanceof IEquatable) {
				$t = $this->GetType();
				trigger_error(sprintf(_('You implemented IEquatable interface, but using default Object::Equals() method. You must override it, creating %s::Equals() public method.'), $t->Name), E_USER_NOTICE);
			}

			return $this == $other;
		}


	}

	endif;
}


