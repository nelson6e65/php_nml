<?php
	if (!defined('C_NotImplementedException'))
		define('C_NotImplementedException', true);
	
	class InvalidOperationException extends Exception {
		function __construct($functionName) {
			$e = "El método '$msg' no está implementado.";
			parent::__construct($e);
		}
	}
?>