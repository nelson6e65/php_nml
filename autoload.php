<?php

bindtextdomain('nml', __DIR__ . DIRECTORY_SEPARATOR . 'Locale');

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
		return; // Only checks for NelsonMartell namespace.
	}

	$path = sprintf('%s' . DIRECTORY_SEPARATOR . '%s.php', __DIR__, implode(DIRECTORY_SEPARATOR, $classArray));

	if (is_file($path)) {
		require_once($path);
	} else {
		throw new Exception(sprintf('Unable to auto-load class "%s" in path "%s": File do not exist (wrong sub-namespace?). Check for availability of that class in Nelson Martell Library (NML).', $class, $path));
	}
}

spl_autoload_register('autoload_NML');
