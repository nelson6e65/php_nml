<?php
# #####################################################
# Clase «Version» para PHP 
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
$_class = "Version";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);

	include('Object.php');
	include('IntString.php');
	
	/* 
	 * Representa el número de versión de un elemento o ensamblado. No se puede heredar esta clase.
	 * 
	 * @package  NelsonMartell.Version
	 * @author  Nelson Martell (nelson6e65-dev@yahoo.com)
	 * @license  MIT license
	 * */
	final class Version extends Object {
		
		/* 
		 * Crea una nueva instancia con los números principal, secundario, de compilación y 
		 * revisión. Si no se especifica ninguno, se usará el valor predeterminado (0.0).
		 * 
		 * @exceptions InvalidArgumentException, OutOfRangeException
		 * */
		function __construct($major = 0, $minor = 0, $build = 0, $revision = 0) {
			parent::__construct();
			unset($this->Major, $this->Minor, $this->Build, $this->Revision);
			
			if (!is_integer($major)) {
				throw new InvalidArgumentException(sprintf(_("Invalid type on setter. You are trying to set '%s' property with an invalid type. 'value' must be an instance of '%s'; '%s' given."), "Version::Major", gettype(0), gettype($value)));
			}
			
			if ($major < 0) {
				throw new OutOfRangeException(sprintf(_("Value for '%s' property must be positive; '%s' given"), "Version::Major", $value));
			}
			
			if (!is_integer($minor)) {
				throw new InvalidArgumentException(sprintf(_("Invalid type on setter. You are trying to set '%s' property with an invalid type. 'value' must be an instance of '%s'; '%s' given."), "Version::Minor", gettype(0), gettype($value)));
			}
			
			if ($minor < 0) {
				throw new OutOfRangeException(sprintf(_("Value for '%s' property must be positive; '%s' given"), "Version::Minor", $value));
			}			
			
			$this->_major = $major;
			$this->_minor = $minor;
			$this->_build = IntString::Parse($build);
			$this->_revision = IntString::Parse($revision);
			
		}
		
		/*
		public static function Parse($version) {
			$version = explode('.', $version, 4);
			
			$major = (int) $version[0];
			$minor = (int) $version[1];
			
			$build = (string) $version[2];
			$revision = (string) $version[3];
			
			return new Version($major, $minor, $build, $revision);
		}
		*/
		
		
		
		private $_major;
		
		public $Major;
		
		/* 
		 * Obtiene el valor del componente principal del número de versión del objeto actual.
		 * 
		 * @return  int Componente principal del número de versión
		 * */		
		public function get_Major() { return $this->_major; }
		
		
		private $_minor;
		
		public $Minor;
		
		/* 
		 * Obtiene el valor del componente secundario del número de versión del objeto actual. 
		 * 
		 * @return  int Componente secundario del número de versión
		 * */
		public function get_Minor() { return $this->_minor; }		
		
		
		private $_build;
		
		public $Build;
		
		/* 
		 * Obtiene el valor del componente de compilación del número de versión del objeto actual. 
		 * 
		 * @return  int Componente de compilación del número de versión
		 * */
		public function get_Build() { return $this->_build->ToString(); }
		
		
		private $_revision;
		
		public $Revision;
		
		/* 
		 * Obtiene el valor del componente de revisión del número de versión del objeto actual. 
		 * 
		 * @return  int Componente de revisión del número de versión
		 * */
		public function get_Revision() { return $this->_revision->ToString(); }	
		
		
		/* 
		 * Convierte la instancia actual en su representación en cadena.
		 * Por defecto, si no se especifica el número de revisión (o es menor a 1), 
		 * no se incluye en la salida.
		 * Si tampoco se especifica el número de compilación (o es menor a 1), 
		 * tampoco se incluye el número de revisión.
		 * Los componentes principal y secundario siempre se muestran, aunque sean cero (0).
		 * 
		 * @return  string Representación de la versión en forma de cadena: 
		 *   'major.minor[.build[.revision]]'
		 * */
		public function ToString() {
			$s = $this->Major . '.' . $this->Minor;
			if ($this->Build->IntValue > 0){
				$s .= '.' . $this->Build;
				
				if ($this->Revision->IntValue > 0) {
					$s .= '.' . $this->Revision;
				}
				
			}
			
			return $s;
		}
		
		/*
		 * Indica si la instancia actual es un número de versión válido. 
		 * Al menos un atributo de la versión debe estar establecido.
		 * @return  boolean Un valor que indica si la instancia actual es válida.
		 * */
		public function IsValid() {
			if (!$this->Major){
				if (!$this->Minor) {
					if (!$this->Build->IntValue > 0) {
						if (!$this->Revision->IntValue > 0) {
							return false;
						}
					}
				}
			}
			
			return true;
		}
	}
	
endif;
