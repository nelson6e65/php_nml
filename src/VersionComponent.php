<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2015-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell;

use InvalidArgumentException;

/**
 * Representa un componente de un número de Version.
 * Extiende la clase IntString, pero restringe los valores que puede tomar.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.1.1
 * */
class VersionComponent extends IntString implements IEquatable
{
    /**
     *
     *
     * @param int|null    $intValue
     * @param string|null $stringValue
     */
    public function __construct($intValue = null, $stringValue = null)
    {
        // Validates filters for only null or int/string value types.
        parent::__construct($intValue, $stringValue);

        $intValue    = $this->intValue;
        $stringValue = $this->stringValue;

        if ($intValue === null) {
            // Ignore string value if intValue is null.
            $stringValue = '';
        } else {
            // Validation of values
            if ($intValue < 0) {
                $args = [
                    'position' => '1st',
                    'actual'   => $intValue,
                ];

                $msg = msg('Invalid argument value.');
                $msg .= msg(
                    ' {position} argument must to be a positive number; "{actual}" given.',
                    $args
                );

                throw new InvalidArgumentException($msg);
            } // Integer is valid

            if ($stringValue !== null) {
                if ($stringValue != '') {
                    $pattern = '~^([a-z])$~'; // 1 char

                    if (strlen($stringValue) > 1) {
                        $start = '~^([a-z]|-)';
                        $middle = '([a-z]|[0-9]|-)*';
                        $end = '([a-z]|[0-9])$~';

                        $pattern = $start.$middle.$end;
                    }

                    $correct = (boolean) preg_match($pattern, $stringValue);

                    if ($correct) {
                        //Último chequeo: que no hayan 2 '-' consecutivos.
                        $correct = strpos($stringValue, '--') == false ? true : false;
                    }

                    if (!$correct) {
                        $args = [
                            'position' => '2nd',
                            'actual'   => $stringValue,
                        ];

                        $msg = msg('Invalid argument value.');
                        $msg .= msg(
                            ' {position} parameter has invalid chars; "{actual}" given.',
                            $args
                        );

                        throw new InvalidArgumentException($msg);
                    }
                }
            } // String is valid
        }

        parent::__construct($intValue, $stringValue);
    }

    public static function parse($obj)
    {
        if ($obj instanceof VersionComponent) {
            return $obj;
        } else {
            if ($obj === null || (is_string($obj) && trim($obj) === '')) {
                return new VersionComponent();
            }
        }

        $objConverted = parent::parse($obj);

        return new VersionComponent($objConverted->intValue, $objConverted->stringValue);
    }

    /**
     * Determina si este componente tiene los valores predeterminados (0).
     *
     * @return bool
     * */
    public function isDefault()
    {
        if ($this->intValue === 0) {
            if ($this->stringValue === '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determina si este componente NO tiene los valores predeterminados.
     *
     * @return bool
     * */
    public function isNotDefault()
    {
        return !$this->isDefault();
    }

    /**
     * Determina si esta instancia es nula.
     *
     * @return bool
     * */
    public function isNull()
    {
        if ($this->intValue === null) {
            return true;
        }

        return false;
    }

    /**
     * Determina si esta instancia NO es nula.
     *
     * @return bool
     * */
    public function isNotNull()
    {
        return !$this->isNull();
    }

    public function equals($other)
    {
        if ($other instanceof VersionComponent) {
            if ($this->intValue === $other->intValue) {
                if ($this->stringValue === $other->stringValue) {
                    return true;
                }
            }
        } else {
            return parent::equals($other);
        }

        return false;
    }

    public function compareTo($other)
    {
        if ($other === null) {
            return 1;
        } elseif ($this->equals($other)) {
            return 0;
        } elseif ($other instanceof VersionComponent) {
            // null < int
            if ($this->isNull()) {
                $r = -1;
            } elseif ($other->isNull()) {
                $r = 1;
            } else {
                // Here are evaluated as integers
                $r = $this->intValue - $other->intValue;

                if ($r === 0) {
                    $r = strnatcmp($this->stringValue, $other->stringValue);
                }
            }
        } elseif (is_integer($other) || is_array($other)) {
            $r = 1;
        } elseif (is_string($other)) {
            try {
                $r = $this->compareTo(static::parse($other));
            } catch (InvalidArgumentException $e) {
                $r = 1;
            }
        } else {
            $r = null;
        }

        return $r;
    }
}
