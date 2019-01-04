<?php
/**
 * Custom autoloader for non-composer installations.
 * This function only load classes under 'NelsonMartell' namespace and skips in
 * any other case.
 * If NML class file is not found, throws and exception.
 *
 * Note: If you are using "NelsonMartell" as main namespace in a file that not
 * belongs to NML, you should include it before to load "NML/autoload.php" or,
 * using SPL autoload features, register autoload function for that class(es)
 * using "prepend" argument set to TRUE.
 * Example, if your autoload function is named "no_NML_autoload_function", you
 * can use something like:
 * spl_autoload_register("no_NML_autoload_function", true, TRUE).
 *
 * @param string $class NML class name (full cualified name).
 *
 * @return void
 */
function autoloadNelsonMartellLibrary($class)
{
    static $DS = DIRECTORY_SEPARATOR;

    if ($class[0] == '\\') {
        $class = substr($class, 1);
    }

    $classArray = explode('\\', $class);

    if ($classArray[0] == 'NelsonMartell') {
        $classArray[0] = 'src';
    } else {
        // Only checks for NelsonMartell namespace.
        return;
    }

    $path = sprintf('%s'.$DS.'%s', __DIR__.$DS.'..', implode($DS, $classArray));

    if (is_file($path.'.php')) {
        $path .= '.php';
    } elseif (is_file($path.'.inc')) {
        $path .= '.inc';
    } else {
        $msg = 'Unable to auto-load "%s" class in Nelson Martell Library (NML): "%s" file was not found.'.
            ' You can see the API documentation (http://nelson6e65.github.io/php_nml/api) in order to check '.
            ' availability of all classes/namespaces in NML. Note: If you are using "NelsonMartell" as main namespace'.
            ' in a file that not belongs to NML, you should include it before to load "NML/autoload.php" or,'.
            ' using SPL autoload features, register autoload function for that class(es) using "prepend" argument for'.
            ' spl_autoload_register function set to TRUE.';

        throw new Exception(sprintf(dgettext('nml', $msg), $class, $path));
    }

    require_once($path);
}
