<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  VersionComponent
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.1.1
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    use \InvalidArgumentException;

    /**
     * Representa un componente de un número de Version.
     * Extiende la clase IntString, pero restringe los valores que puede tomar.
     *
     *
     * @author  Nelson Martell <nelson6e65-dev@yahoo.es>
     * */
    class VersionComponent extends IntString implements IEquatable
    {

        public function __construct($intValue = null, $stringValue = null)
        {
            parent::__construct($intValue, $stringValue);

            if (is_integer($intValue)) {
                //Validaciones:
                if ($this->IntValue < 0) {
                    throw new InvalidArgumentException(
                        sprintf(
                            dgettext(
                                'nml',
                                'Invalid argument value. "%s" (argument %s) must be positive; "%s" given.'
                            ),
                            '$intValue',
                            1,
                            $intValue
                        )
                    );
                }
            } else {
                if ($intValue === null) {
                    if ($stringValue != null) {
                        throw new InvalidArgumentException(
                            sprintf(
                                dgettext(
                                    'nml',
                                    'Invalid argument type. "%s" must be NULL when "%s" is NULL; "%s" given.'
                                ),
                                '$stringValue',
                                '$intValue',
                                $stringValue
                            )
                        );
                    }
                } else {
                    throw new InvalidArgumentException(
                        sprintf(
                            dgettext(
                                'nml',
                                'Invalid argument type. "%s" (argument %s) must be an integer or NULL; "%s" given.'
                            ),
                            '$intValue',
                            1,
                            $intValue
                        )
                    );
                }
            } //Only integer or null

            if (is_string($stringValue)) {
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
                        throw new InvalidArgumentException(
                            sprintf(
                                dgettext(
                                    'nml',
                                    'Invalid argument value. "%s" (argument %s) has invalid chars: "%s".'
                                ),
                                '$stringValue',
                                2,
                                $stringValue
                            )
                        );
                    }

                }
            } else {
                if ($stringValue != null) {
                    throw new InvalidArgumentException(
                        sprintf(
                            dgettext(
                                'nml',
                                'Invalid argument type. "%s" (argument %s) must be an string or NULL; "%s" given.'
                            ),
                            '$stringValue',
                            2,
                            $stringValue
                        )
                    );
                }
            } // Only integer or null
        }

        public static function parse($value = null)
        {
            if ($value instanceof VersionComponent) {
                return $value;
            }

            if ($value === null or trim((string) $value) === '') {
                return new VersionComponent();
            }

            $s = parent::Parse($value);

            $r = new VersionComponent($s->IntValue, $s->StringValue);

            return $r;
        }

        /**
         * Determina si este componente tiene los valores predeterminados (0).
         *
         *
         * @return  boolean
         * */
        public function isDefault()
        {
            if ($this->IntValue == 0) {
                if ($this->StringValue == '') {
                    return true;
                }
            }

            return false;
        }


        /**
         * Getter method for VersionComponent::IntValue property.
         *
         * @return  integer|NULL
         * */
        public function getIntValue()
        {
            return $this->intValue;
        }


        /**
         * Determina si este componente NO tiene los valores predeterminados.
         *
         *
         * @return  boolean
         * */
        public function isNotDefault()
        {
            return !$this->IsDefault();
        }

        /**
         * Determina si esta instancia es nula.
         *
         * @return  boolean
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
         * @return  boolean
         * */
        public function isNotNull()
        {
            return !$this->IsNull();
        }
    }
}
