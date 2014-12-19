<?php
# Archivo: Nelson/includes/class/Exceptions/ALL.inc
# Incluye todas las clases de excepciones de este directorio
# Creación: 	2013-05-20
# Modificado: 	2013-05-20
# Copyright © 2013 Nelson Martell (nelson6e65-dev@yahoo.es)



	if (!defined("EXCEPTIONS_ALL")) {
		define('EXCEPTIONS_ALL', true);
		
		if (!defined('DEBUG'))
			define('DEBUG', true);
		
		include("ArgumentException.php");
		include("ArgumentNullException.php");
		include("InvalidOperationException.php");
		include("InvalidTypeException.php");
	}
	
	
?>