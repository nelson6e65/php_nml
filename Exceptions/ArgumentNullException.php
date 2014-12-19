<?php
if (!defined('C_ArgumentNullException')) {
	define('C_ArgumentNullException', true);
	
	if (!defined('C_ArgumentException')) 
		include('ArgumentException.php');
	

	class ArgumentNullException extends ArgumentException {
		function __construct($argName, $msg = "", $innerException = null, $code = 0) {	
			parent::__construct($argName, "null", $msg, $innerException, $code);
		}
	}
}
?>