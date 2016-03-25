<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
 *
 * Copyright © 2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\plugins;

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
     * @param mixed $obj Object to export.
     * @return string
     * @see Exporter::shortenedRecursiveExport()
     * @see Exporter::export()
     */
    public static function export($obj)
    {
        if (static::$exporter === null) {
            static::$exporter = new Exporter();
        }

        $type = NML\typeof($obj);

        if ($type->canBeString() && $type->isCustom()) {
            $str = "{$type->Name} { {$obj} }";
        } elseif ($type->isCustom()) {
            $str = static::$exporter->shortenedRecursiveExport($obj);
        } else {
            $str = static::$exporter->export($obj);

            if ($type->Name === 'array') {
                // Remove 'Array' label
                $str = substr($str, strpos($str, '('));

                // Remove unnecesary spaces
                $str = str_replace(["\r", "\t", '  '], '', $str);

                // Replace '(', ')' and adding ',' separator
                $str = str_replace(["(\n", "\n)", "\n"], ['[', ']', ', '], $str);

            }
        }

        return $str;
    }
}
