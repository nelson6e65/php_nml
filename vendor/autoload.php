<?php

/**
 * Custom autoloader for non-composer installations.
 * This function only load vendor classes.
 *
 * @param   string  $class  Class name.
 * @return  void
 */
function autoload_NML_Vendors($class)
{
    if ($class[0] == '\\') {
        $class = substr($class, 1);
    }

    $classArray = explode('\\', $class);

    $path = sprintf('%s' . DIRECTORY_SEPARATOR . '%s.php', __DIR__, implode(DIRECTORY_SEPARATOR, $classArray));

    if (is_file($path)) {
        require_once($path);
    }
}

spl_autoload_register('autoload_NML_Vendors');
