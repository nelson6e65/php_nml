<?php
if (!defined('C_ArgumentException')) {
	define('C_ArgumentException', true);
		
	class ArgumentException extends Exception {
		///<param name="$argName" type="string">Nombre del argumento que genera la excepción</param>
		///<param name="$argValue" type="object">Valor del argumento que genera la excepción</param>
		///<param name="$msg" type="string">Detalles</param>
		function __construct($argName, $argValue, $msg = ""/*, $innerException = null, $code = 0*/) {
			$e = "El valor del argumento '$argName' no puede ser '$argValue'. Más detalles:\n$msg";
			parent::__construct($e, Exception::getCode()/*, $innerException*/);
		}
	}
}
?>