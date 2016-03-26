<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  VersionComponent
 *
 * Copyright © 2015-2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.1.1
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    use \InvalidArgumentException;

    /**
     * Representa un componente de un número de Version.
     * Extiende la clase IntString, pero restringe los valores que puede tomar.
     *
     * @author Nelson Martell <nelson6e65@gmail.com>
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

            if ($intValue === null) {
                $this->intValue = $intValue;

                // Ignore string value if intValue is null.
                $this->stringValue = '';
            } else {
                // Validation of values
                if ($this->IntValue < 0) {
                    $args = [
                        'position' => '1st',
                        'actual'   => $intValue,
                    ];

                    $msg = nml_msg('Invalid argument value.');
                    $msg .= nml_msg(
                        ' {position} argument must to be a positive number; "{actual}" given.',
                        $args
                    );

                    throw new InvalidArgumentException($msg);
                } // Integer is valid

                if ($stringValue !== null) {
                    if ($this->StringValue != '') {
                        $pattern = '~^([a-z])$~'; // 1 char

                        if (strlen($this->StringValue) > 1) {
                            $start = '~^([a-z]|-)';
                            $middle = '([a-z]|[0-9]|-)*';
                            $end = '([a-z]|[0-9])$~';

                            $pattern = $start.$middle.$end;
                        }

                        $correct = (boolean) preg_match($pattern, $this->StringValue);

                        if ($correct) {
                            //Último chequeo: que no hayan 2 '-' consecutivos.
                            $correct = strpos($this->StringValue, '--') == false ? true : false;
                        }

                        if (!$correct) {
                            $args = [
                                'position' => '2nd',
                                'actual'   => $stringValue,
                            ];

                            $msg = nml_msg('Invalid argument value.');
                            $msg .= nml_msg(
                                ' {position} parameter has invalid chars; "{actual}" given.',
                                $args
                            );

                            throw new InvalidArgumentException($msg);
                        }
                    }
                } // String is valid
            }
        }

        public static function parse($value = null)
        {
            if ($value instanceof VersionComponent) {
                return $value;
            }

            if ($value === null or trim((string) $value) === '') {
                return new VersionComponent();
            }

            $s = parent::parse($value);

            $r = new VersionComponent($s->IntValue, $s->StringValue);

            return $r;
        }

        /**
         * Determina si este componente tiene los valores predeterminados (0).
         *
         * @return boolean
         * */
        public function isDefault()
        {
            if ($this->IntValue === 0) {
                if ($this->StringValue === '') {
                    return true;
                }
            }

            return false;
        }


        /**
         * Getter method for VersionComponent::IntValue property.
         *
         * @return integer|NULL
         * */
        public function getIntValue()
        {
            return $this->intValue;
        }


        /**
         * Determina si este componente NO tiene los valores predeterminados.
         *
         * @return boolean
         * */
        public function isNotDefault()
        {
            return !$this->isDefault();
        }

        /**
         * Determina si esta instancia es nula.
         *
         * @return boolean
         * */
        public function isNull()
        {
            if ($this->IntValue === null) {
                return true;
            }

            return false;
        }

        /**
         * Determina si esta instancia NO es nula.
         *
         * @return boolean
         * */
        public function isNotNull()
        {
            return !$this->isNull();
        }

        public function equals($other)
        {
            if ($other instanceof VersionComponent) {
                if ($this->IntValue === $other->IntValue) {
                    if ($this->StringValue === $other->StringValue) {
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
                    $r = $this->IntValue - $other->IntValue;

                    if ($r === 0) {
                        $r = strnatcmp($this->StringValue, $other->StringValue);
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
}
