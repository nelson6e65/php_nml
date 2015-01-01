<?php

/*
 * Clase para manejar los directorios de los diferentes recursos
 * */
 
if (!defined("NelsonMartell.Cake.Asset")) {
	define("NelsonMartell.Cake.Asset", true);
	
	require('../Object.php');
	
	public class Asset extends Object {
		
		public function __construct($name, $versions) {
			if (!is_string($name))
				throw new BadArgumentException(_('The name of resource must be a string.'));
			
			$this->name = $name;
			
			if()
			$this->version = $versions;
		}
		
		public $name = '';
		
		public $version = '';
		
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
		public function getPath(boolean $endWithName = false, string $append = ''){
			
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
