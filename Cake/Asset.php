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
		/* *
		 * Crea una nueva instancia de la clase Asset
		 * 
		 * 
		 * 
		 * */
		public function __construct($name = '', $versions = null, $cdnUri = null) {
			parent::__construct();
			unset($this->Name, $this->Versions, $this->ShortName, $this->CdnUri);
			
			if ($name == '') {
				if ($versions != null) {
					throw new InvalidArgumentException(_('The $name of resource can not be null.'));
				}
			} else {
				$this->_name = $name;
				
				if (is_array($versions)) {
					$this->_versions = $versions;
				}
			
			}
			
		}
		
		
		/*
		 * Obtiene o establece el nombre original del recurso.
		 * 
		 * @var  string Nombre del recurso
		 * */
		public $Name;
		private $_name;
		
		public function get_Name() {
			return $this->_name;
		}
		
		public function set_Name($value) {
			if (!is_string($value)) {
				throw new InvalidArgumentException('$value argument must be string.');
			}
			
			if (str_word_count($value) == 0) {
				throw new InvalidArgumentException('$value argument can not be an empty or whitespace string.');
			}
			
			$this->_name = trim($value);
			
			$this->_shortName = str_replace(' ', '-', strtolower($this->_name));
		}
		
		/*
		 * Obtiene el nombre auto-generado del recurso.
		 * 
		 * @var  string Nombre del recurso en su forma generada
		 * */
		public $ShortName;
		private $_shortName;
		
		public function get_ShortName() {
			return $this->_shortName;
		}
		
		/*
		 * Obtiene la lista de versiones
		 * 
		 * @var  List Lista de versiones del recurso
		 * */
		public $Versions;
		private $_versions;
		
		public function get_Versions() {
			return $this->_versions;
		}
		/*
		public function set_Versions($value) {
			$this->_versions = $value;
		}
		*/
		
		
		/* *
		 * Obtiene o establece el CDN del recurso.
		 * Debe modificarse la URL, colocando '{v}' en vez de la versión.
		 * @example  Un CDN para el JavaScript de jQuery UI v1.11.2 es:
		 *   "//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"
		 *   Entonces el valor de esta propiedad debe ser:
		 *   "//ajax.googleapis.com/ajax/libs/jqueryui/{v}/jquery-ui"
		 * 
		 * 
		 * 
		 * @var  string CDN
		 * */
		public $CdnUri;
		private $_cdnUri;
		
		public function get_CdnUri() {
			return $this->_cdnUri;
		}
		
		public function set_CdnUri($value) {
			$this->_cdnUri = (string) $value;
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
	