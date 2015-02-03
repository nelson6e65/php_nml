<?php

if (!defined('DS')) {
    /**
	 * Define DS as short form of DIRECTORY_SEPARATOR.
	 *
	 */
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Custom autoloader for non-composer installations.
 *
 */
function autoload_NML($class) {
	if ($class[0] == '\\') {
		$class = substr($class, 1);
	}

	$classArray = explode('\\', $class);

	if ($classArray[0] == 'NelsonMartell') {
		$classArray[0] = 'src';
	} else {
		return;
	}

	$path = sprintf('%s' . DS . '%s.php', __DIR__, implode(DS, $classArray));

	if (is_file($path)) {
		require_once($path);
	} else {
		throw new Exception(sprintf('Unable to auto-load class "%s" in path "%s": File do not exist (Wrong sub-namespace?). Check for availability of that class in Nelson Martell Library.', $class, $path));
	}
}

spl_autoload_register('autoload_NML');
