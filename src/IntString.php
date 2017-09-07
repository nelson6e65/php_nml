<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  IntString
 *
 * Copyright © 2015-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use NelsonMartell\Extensions\Text;
use \InvalidArgumentException;

/**
 * Representa un elemento mixto, compuesto por un entero y una cadena unidos
 * (en ese orden).
 * El método IntString::toString obtiene esa cadena compuesta.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
class IntString extends Object implements IEquatable, IComparable
{
    /**
     * @param integer     $intValue    Integer part. Default: ``0`` (zero).
     * @param string|null  $stringValue String part. Default: ``''`` (empty).
     */
    public function __construct($intValue = 0, $stringValue = '')
    {
        unset($this->IntValue, $this->StringValue);

        if (!(is_integer($intValue) || $intValue === null)) {
            $args = [
                'position' => '1st',
                'expected' => typeof(0).'" or "'.typeof(null),
                'actual'   => typeof($intValue),
            ];

            $msg = msg('Invalid argument type.');
            $msg .= msg(
                ' {position} parameter must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );

            throw new InvalidArgumentException($msg);
        }

        if (!typeof($stringValue)->canBeString()) {
            $args = [
                'position' => '2nd',
                'expected' => typeof('string').'", "'.typeof(null).'" or "any object convertible to string',
                'actual'   => typeof($stringValue),
            ];

            $msg = msg('Invalid argument type.');
            $msg .= msg(
                ' {position} parameter must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );

            throw new InvalidArgumentException($msg);
        }

        $this->intValue = (integer) $intValue;
        $this->stringValue = (string) $stringValue;
    }

    /**
     * Convert the object to an instance of ``IntString``.
     *
     * @param string|IntString $obj Object to convert to ``IntString``.
     *
     * @return IntString
     * @throws InvalidArgumentException if object is not a string or format is invalid.
     */
    public static function parse($obj)
    {
        if ($obj instanceof IntString) {
            return $obj;
        }

        if (is_integer($obj)) {
            return new VersionComponent($obj);
        }

        try {
            $intValue = (integer) Text::ensureIsString($obj);
        } catch (InvalidArgumentException $e) {
            $args = [
                'position' => '1st',
                'expected' => 'string" or "integer',
                'actual'   => typeof($obj),
            ];

            $msg = msg('Invalid argument type.');
            $msg .= msg(
                ' {position} parameter must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );

            throw new InvalidArgumentException($msg, 1, $e);
        }

        $stringValue = ltrim($obj, "$intValue");

        // Validate that 0 (zero) is not interpreted as '' (empty string)
        if ($stringValue === $obj) {
            $msg = msg('Invalid argument value.');
            $msg .= msg(' "{0}" (string) must to start with an integer.', $obj);

            throw new InvalidArgumentException($msg);
        }

        return new IntString($intValue, $stringValue);
    }

    protected $intValue;
    protected $stringValue;

    /**
     * @var int
     */
    public $IntValue;
    public function getIntValue()
    {
        return $this->intValue;
    }

    /**
     * @var string
     */
    public $StringValue;
    public function getStringValue()
    {
        return $this->stringValue;
    }

    public function toString()
    {
        return $this->IntValue.$this->StringValue;
    }

    public function equals($other)
    {
        if ($other instanceof IntString) {
            if ($this->IntValue === $other->IntValue) {
                if ($this->StringValue === $other->StringValue) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Determina la posición relativa de esta instancia con respecto al
     * objeto especificado.
     * Nota: Cualquier objeto que no sea instancia de IntString se
     * considerará menor.
     *
     * @param IntString|mixed $other Objeto con el que se va a comparar.
     *
     * @return int Cero (0), si esta instancia es igual a $other; mayor
     *   a cero (>0), si es mayor a $other; menor a cero (<0), si es menor.
     * */
    public function compareTo($other)
    {
        $r = $this->equals($other) ? 0 : 9999;

        if ($r != 0) {
            if ($other instanceof IntString) {
                $r = $this->IntValue - $other->IntValue;

                if ($r == 0) {
                    $r = strnatcmp($this->StringValue, $other->StringValue);
                }
            } else {
                $r = 1;
            }
        }

        return $r;
    }
}
