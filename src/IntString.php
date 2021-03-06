<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2015-2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell;

use InvalidArgumentException;
use NelsonMartell\Extensions\Text;

/**
 * Representa un elemento mixto, compuesto por un entero y una cadena unidos
 * (en ese orden).
 * El método IntString::toString obtiene esa cadena compuesta.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.1.1
 *
 * @property-read int    $intValue    Gets the integer part.
 * @property-read string $stringValue Gets the string part.
 * */
class IntString extends StrictObject implements IEquatable, IComparable
{
    /**
     * Creates a new IntString instance.
     *
     * @param int|null     $intValue    Integer part. Default: `0` (zero).
     * @param string|null  $stringValue String part. Default: `''` (empty).
     *
     * @since 1.0.0-dev Allow `null` value for `$intValue`.
     */
    public function __construct(?int $intValue = 0, $stringValue = '')
    {
        $this->intValue = $intValue;

        if (!typeof($stringValue)->canBeString()) {
            $args = [
                'position' => '2nd',
                'expected' => typeof('string') . '", "' . typeof(null) . '" or "any object convertible to string',
                'actual'   => typeof($stringValue),
            ];

            $msg  = msg('Invalid argument type.');
            $msg .= msg(
                ' {position} parameter must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );

            throw new InvalidArgumentException($msg);
        }

        $this->stringValue = (string) $stringValue;
    }

    /**
     * Converts the object to an instance of `IntString` if compatible.
     *
     * @param mixed $obj Object to convert to `IntString`.
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
            return new IntString($obj);
        }

        try {
            $intValue = (int) Text::ensureIsString($obj);
        } catch (InvalidArgumentException $e) {
            $args = [
                'position' => '1st',
                'expected' => 'string" or "integer',
                'actual'   => typeof($obj),
            ];

            $msg  = msg('Invalid argument type.');
            $msg .= msg(
                ' {position} parameter must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );

            throw new InvalidArgumentException($msg, 1, $e);
        }

        $stringValue = ltrim($obj, "${intValue}");

        // Validate that 0 (zero) is not interpreted as '' (empty string)
        if ($stringValue === $obj) {
            $msg  = msg('Invalid argument value.');
            $msg .= msg(' "{0}" (string) must to start with an integer.', $obj);

            throw new InvalidArgumentException($msg);
        }

        return new IntString($intValue, $stringValue);
    }

    /**
     * Integer part of the instance.
     *
     * @var int
     */
    private $intValue;

    /**
     * String part of the instance.
     *
     * @var string
     */
    private $stringValue;

    /**
     * Getter for $intValue property.
     *
     * @return int|null
     */
    protected function getIntValue()
    {
        return $this->intValue;
    }

    /**
     * Getter for $stringValue property.
     *
     * @return string
     */
    protected function getStringValue(): string
    {
        return $this->stringValue;
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return $this->getIntValue() . $this->getStringValue();
    }

    /**
     * Indicates whether the specified object is equal to the current instance.
     *
     * @param mixed $other
     *
     * @return bool
     */
    public function equals($other): bool
    {
        if ($other instanceof IntString) {
            if ($this->getIntValue() === $other->getIntValue()) {
                if ($this->getStringValue() === $other->getStringValue()) {
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
     * @param mixed $other Objeto con el que se va a comparar.
     *
     * @return int Cero (0), si esta instancia es igual a $other; mayor
     *   a cero (>0), si es mayor a $other; menor a cero (<0), si es menor.
     * */
    public function compareTo($other)
    {
        $r = $this->equals($other) ? 0 : 9999;

        if ($r != 0) {
            if ($other instanceof IntString) {
                $r = $this->intValue - $other->intValue;

                if ($r == 0) {
                    $r = strnatcmp($this->stringValue, $other->stringValue);
                }
            } else {
                $r = 1;
            }
        }

        return $r;
    }
}
