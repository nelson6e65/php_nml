<?php
if (!defined('C_DirectoryInfo')) {

	define('C_DirectoryInfo', true);	
	
	include('Directory.php');
	include('Property.php');
	include('Exceptions/ALL.inc');
		
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
?>