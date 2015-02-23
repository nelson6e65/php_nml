<?php
/**
 * PHP class «DirectoryInfo»
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


if (!defined('C_DirectoryInfo')) {

	define('C_DirectoryInfo', true);	
	
	//include('Directory.php');
	//include('Property.php');
	//include('Exceptions/ALL.inc');
		
		
	
	/**
	 * 
	 * 
	 * 
	 * @todo     Adapt class
	 * @package  NelsonMartell.Version
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	final class DirectoryInfo {
		private $Path;
		
		/// Establece la ruta del directorio
		public function get_Path() {
			return $this->Path->Get();
		}
		
		/// Obtiene el directorio raíz
		private function set_Path($value) {
			$s = trim($value); 
			$s = str_replace('\\', '/', $s);
			$this->Path->Set($s); // Quita espacios al principio y al final de la cadena y la asigna
			
		}
		
		function DirectoryInfo($path) {
			// if ($rootDir == null)
				// throw new InvalidOperationException(, '$rootDir');
			try {
				$this->Root = new Property(".");	
				$this->set_Root($path);
			} catch(Exception $e) {
				throw new InvalidOperationException('No se pudo inicializar el objeto correctamente', $e);
			}
			
			
			
		}
		
	}
}