<?php
	if (!defined('C_InvalidOperationException'))
		define('C_InvalidOperationException', true);
	
	class InvalidOperationException extends Exception {
		function __construct($msg = "", $innerException = null, $code = 0) {
			$e = "Operación inválida. Más detalles:\n$msg";
			parent::__construct($e, Exception::getCode(), $innerException);
		}
	}
?>