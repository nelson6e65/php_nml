<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
 *
 * Copyright © 2016-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use NelsonMartell as NML;
use NelsonMartell\Extensions\String;
use SebastianBergmann\Exporter\Exporter;
use \InvalidArgumentException;

/**
 * Plugin to export variables in test clases.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait ExporterPlugin
{
    protected static $exporter = null;

    /**
     * Extract the string representation of specified object in one line.
     *
     * @param mixed   $obj   Object to export.
     * @param integer $depth How many levels of depth will export in arrays and objects. If $depth <= 0,
     *   only '...' will be returned for content of object or array. Default: ``2``.
     * @param bool    $short If class names are returned without namespace. Default: ``false``.
     *
     * @return string
     * @see Exporter::shortenedRecursiveExport()
     * @see Exporter::export()
     */
    public static function export($obj, $depth = 2, $short = false)
    {
        if (static::$exporter === null) {
            static::$exporter = new Exporter();
        }

        $depth = ((integer) $depth < 0) ? 0 : (integer) $depth;
        $short = (boolean) $short;
        $str   = null;

        if (is_object($obj)) {
            $className = static::getClass($obj, $short);

            if ($depth <= 0) {
                // Do not show properties
                $content = '{...}';
            } else {
                $arrayObject = static::$exporter->toArray($obj);
                // Initial content without deep
                $content = static::export($arrayObject, 1, $short);
                // Replace array braces and separator
                $content = str_replace([' => ', '[ ', ' ]'], [': ', '{ ', ' }'], $content);

                // var_dump($content, $depth);

                if ($depth > 1) {
                    foreach ($arrayObject as $key => $value) {
                        $format = '{0}: {1}';

                        if (is_object($value)) {
                            $sclass = static::getClass($value, $short);

                            $sVal = "$sclass({...})";
                        } elseif (is_array($value)) {
                            $sVal = '[...]';
                        } else {
                            continue;
                        }

                        $search      = String::format($format, $key, $sVal);
                        $replacement = String::format($format, $key, static::export($value, $depth - 1, $short));

                        $content = str_replace($search, $replacement, $content);
                    }
                }
            }

            $str = String::format('{0}({1})', $className, $content);
            $str = str_replace(',  }', ' }', $str);
        } elseif (is_array($obj)) {
            if ($depth <= 0) {
                $str = count($obj) > 0 ? '[...]' : '';
            } else {
                $str = '';
                foreach ($obj as $key => $value) {
                    // Export all items recursively
                    $str .= String::format('{0} => {1}, ', $key, static::export($value, $depth - 1, $short));
                }
                $str = String::format('[ {0} ]', $str);
                $str = str_replace(',  ]', ' ]', $str);
            }
        } else {
            $str = static::$exporter->export($obj);
        }

        return $str;
    }


    /**
     * Exports class name of an object instance.
     *
     * @param object  $obj   Object to get the class name.
     * @param boolean $short Return only class name without namespace.
     *
     * @return string
     */
    public static function getClass($obj, $short = false)
    {
        if (!is_object($obj)) {
            throw new InvalidArgumentException('Object argument is not an object instance.');
        }
        $className = get_class($obj);
        if ($short) {
            $pos = strrpos($className, '\\');
            if ($pos !== false) {
                // Get class name without namespace
                $className = substr($className, $pos + 1);
            }
        }
        return $className;
    }
}
