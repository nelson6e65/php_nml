<?php

/*
 * Clase para manejar los directorios de los diferentes recursos
 * */
public class Resource {
	
	public function __construct($apiName, $apiVersion) {
		$this->name = $apiName;
		$this->version = $apiVersion;
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
