<?php
	if (!defined('C_InvalidTypeException'))
		define('C_InvalidTypeException', true);
		
	class InvalidTypeException extends Exception {
		function __construct($msg, $value = null, $expectedType = null, $innerException = null, $code = 0) {
			$desc = "Tipo inválido";
			if ($value != null) {
				$desc .= ": El valor '$value' es de tipo '" . Type::typeof($value) . "'; ";
				if ($expectedType != null) {
					$desc .= "se esperaba un valor de tipo '$expectedType'";
				}
			}
			
			$desc .= ".\nMás información: $msg";
			
			
			parent::__construct($desc, Exception::getCode(), $innerException);
		}
		
		function __tostring() {
			echo "<pre>";
			$s = parent::__tostring();
			
			// $arr = explode('\r\n', $s);
			
			// $s = implode("<br>", $arr);
			
			// echo "\n<div class=\"debug\">\n", $s, "\n</div>\n";
			
			
			return $s;
		}
	}
?>