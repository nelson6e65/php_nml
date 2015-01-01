<?php

/*
 * Clase para manejar los directorios de los diferentes recursos
 * */

$_namespace = "NelsonMartell/Cake";
$_class = "Asset";

if (!defined($_namespace . '/' . $_class)):
	define($_namespace . '/' . $_class, true);
		
	include('/../Object.php');
	
	class Asset extends Object {
		
		public function __construct($name, $versions) {
			parent::__construct();
			unset($this->Name, $this->Versions);
			
			if (!is_string($name))
				throw new InvalidArgumentException(_('The name of resource must be an string.'));
			
			$this->Name = $name;
			
			if(is_array($versions))
				$this->Versions = $versions;
				
			
		}
		
		private $_name;
		
		/*
		 * Obtiene o establece el nombre del recurso.
		 * */
		public $Name;
		
		public function get_Name() {
			return $this->_name;
		}
		
		public function set_Name($value) {
			if(!is_string($value))
				throw new InvalidArgumentException('$value must be an string');
			
			$this->_name = $value;
		}
		
		private $_versions;
		
		/*
		 * Obtiene o establece la lista de versiones
		 * */
		public $Versions;
		
		public function get_Versions() {
			return $this->_versions;
		}
		
		public function set_Versions($value) {
			$this->_versions = $value;
		}
		
		/*
			public static function getJavascriptPath($api) {
			
			}
			
			public static function getCssPath($api) {
			
			}
			
			public static function getImgPath($api){
			
			}
			
			public static function getResourcesPath($api){
			
		}*/
		
		/*
		 * Obtiene la ruta relativa usando algún auxiliar, como Html->css(), por ejemplo.
		 * */
		public function getPath(boolean $endWithName, string $append){
			
			$ruta = $this->name . '/' . $this->version . '/';
			
			if ($endWithName)
				$ruta .= $this->name;
			
			
			
			if ($append != '')
			$ruta .= $append; //Le adiciona $append al final de la cadena
			
			$ruta = strtolower($ruta); //Conversión a minúsculas
			
			$ruta = str_replace(' ', '-', $ruta);		
			
			return $ruta;
		}	
	}
endif;
	