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

$_namespace = "NelsonMartell";
$_class = "Object";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);
	
	include('Type.php');
	
	/*
	 * Clase base de objetos, para encapsular propiedades y otros métodos básicos.
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
		 * Restringe la obtención de una propiedad no definida dentro de la clase si no posee su
		 * método getter.
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
		
		/*
		 * Establece el valor de una propiedad según el modelo: 'set_' + $name + '(' + $value + ')'
		 * Restringe la asignación de una propiedad no definida dentro de la clase si no posee su
		 * método setter.
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
				throw new BadMethodCallException(sprintf(_("Unable to assign '%s' property in '%s' class. Reason: %s"), $name, $this->GetType()->GetName(), $error));
			}
			
			$this->$setter($value);
		}
		
		
		
		
		/*
		 * Para modificar el funcionamiento de esta función, debe reemplazarse la función
		 * ObjectClass::ToString()
		 * */
		final function __toString() {			
			//$args = null;
			//list($args) = func_get_args();
			return $this->ToString();
		}
		
		public function ToString() {
			$t = $this->GetType();
			
			if ($t->Name != 'Object') {
				trigger_error(sprintf(_('Using default Object::ToString() method. You must override it, creating %s::ToString() public method.'), $t->Name), E_USER_NOTICE);
			}
				
			return '{' . $this->GetType() . '}'; 
			
		}
		
		public final function GetType() {
			return typeof($this);
		}
		
		
		
		
	}
	
endif;
