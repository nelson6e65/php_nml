<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  Version
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
     * Representa el número de versión de un programa o ensamblado, de la forma "1.2.3.4". Sólo
     * siendo obligatorios el primer y segundo componente.
     * No se puede heredar esta clase.
     *
     * @author Nelson Martell <nelson6e65@gmail.com>
     * */
    final class Version extends Object implements IEquatable, IComparable
    {

        /**
         * Crea una nueva instancia con los números principal, secundario, de
         * compilación (opcional) y revisión (opcional).
         * Para comprobar si la versión es válida, usar el método isValid.
         *
         * @param int                              $major    Componente principal
         * @param int                              $minor    Componente secundario
         * @param int|string|VersionComponent|null $build    Componente de compilación
         * @param int|string|VersionComponent|null $revision Componente de revisión
         *
         * @throws InvalidArgumentException
         * */
        public function __construct($major, $minor, $build = null, $revision = null)
        {
            parent::__construct();
            unset($this->Major, $this->Minor, $this->Build, $this->Revision);

            if (!is_integer($major)) {
                $args = [
                    'class'    => typeof($this)->Name,
                    'name'     => 'major',
                    'pos'      => 0,
                    'expected' => typeof(0),
                    'actual'   => typeof($major),
                ];

                $msg = nml_msg('Invalid argument type.');
                $msg .= nml_msg(
                    ' "{name}" (position {pos}) must to be an instance of "{expected}"; "{actual}" given.',
                    $args
                );
                $msg .= nml_msg(' Convert value or use the "{class}::parse" (static) method.', $args);

                throw new InvalidArgumentException($msg);
            }

            if (!is_integer($minor)) {
                $args = [
                    'class'    => typeof($this)->Name,
                    'name'     => 'minor',
                    'pos'      => 1,
                    'expected' => typeof(0),
                    'actual'   => typeof($minor),
                ];

                $msg = nml_msg('Invalid argument type.');
                $msg .= nml_msg(
                    ' "{name}" (position {pos}) must to be an instance of "{expected}"; "{actual}" given.',
                    $args
                );
                $msg .= nml_msg(' Convert value or use the "{class}::parse" (static) method.', $args);

                throw new InvalidArgumentException($msg);
            }

            if ($major < 0) {
                $args = [
                    'name'     => 'major',
                    'pos'      => 0,
                    'actual'   => $major,
                ];

                $msg = nml_msg('Invalid argument value.');
                $msg .= nml_msg(
                    ' "{name}" (position {pos}) must to be a positive number; "{actual}" given.',
                    $args
                );

                throw new InvalidArgumentException($msg);
            }

            if ($minor < 0) {
                $args = [
                    'name'     => 'minor',
                    'pos'      => 1,
                    'actual'   => $minor,
                ];

                $msg = nml_msg('Invalid argument value.');
                $msg .= nml_msg(
                    ' "{name}" (position {pos}) must to be a positive number; "{actual}" given.',
                    $args
                );

                throw new InvalidArgumentException($msg);
            }

            $this->major = $major;
            $this->minor = $minor;
            $this->build = VersionComponent::Parse($build);
            $this->revision = VersionComponent::Parse($revision);
        }

        /**
         * Convierte una cadena a su representación del tipo Version.
         *
         * @param Version|string|int|float|array $value Objeto a convertir.
         *
         * @return Version Objeto convertido desde $value.
         * */
        public static function parse($value)
        {
            if ($value instanceof Version) {
                return $value;
            }

            $version = [];

            // Try to convert into an array
            if (is_integer($value)) {
                // Integer for major value
                $version = [$value, 0];
            } elseif (is_float($value)) {
                // Integer part as major, and decimal part as minor
                $version = sprintf("%F", $value);
                $version = explode('.', $version);
            } elseif (is_array($value)) {
                // Implode first 4 places for major, minor, build and revision respectivally.
                $version = array_slice($value, 0, 4);
            } elseif (is_string($value)) {
                $version = explode('.', $value);
            } else {
                $msg = nml_msg('Unable to parse. Argument passed has an invalid type: "{0}".', typeof($value));
                throw new InvalidArgumentException($msg);
            }

            // $value ya debería ser un array.
            $c = count($version);

            if ($c > 4 || $c < 2) {
                $msg = nml_msg('Unable to parse. Argument passed has an invalid format: "{0}".', $value);
                //var_dump($version);
                throw new InvalidArgumentException($msg);
            }


            $major = (int) $version[0];
            $minor = (int) $version[1];
            $build = null;
            $revision = null;

            if (count($version) >= 3) {
                $build = VersionComponent::Parse($version[2]);

                if (count($version) == 4) {
                    $revision = VersionComponent::Parse($version[3]);
                }
            }

            return new Version($major, $minor, $build, $revision);
        }

        /**
         * Obtiene el valor del componente principal del número de versión del
         * objeto actual.
         * Esta propiedad es de sólo lectura.
         *
         * @var int Componente principal del número de versión.
         * */
        public $Major;
        private $major;

        /**
         * Getter for Major property.
         *
         * @return integer
         * @see    Version::Major.
         */
        public function getMajor()
        {
            return $this->major;
        }


        /**
         * Obtiene el valor del componente secundario del número de versión del
         * objeto actual.
         * Esta propiedad es de sólo lectura.
         *
         * @var int Componente secundario del número de versión.
         * */
        public $Minor;
        private $minor;

        /**
         * Getter for minor property.
         *
         * @return integer
         * @see    Version::Minor.
         */
        public function getMinor()
        {
            return $this->minor;
        }

        /**
         * Obtiene el valor del componente de compilación del número de versión
         * del objeto actual.
         * Esta propiedad es de sólo lectura.
         *
         * @var VersionComponent Componente de compilación del número de versión.
         * */
        public $Build;
        private $build;

        /**
         * Getter for Build property.
         *
         * @return VersionComponent
         * @see    Version::Build
         */
        public function getBuild()
        {
            return $this->build;
        }

        /**
         * Obtiene el valor del componente de revisión del número de versión del
         * objeto actual.
         * Esta propiedad es de sólo lectura.
         *
         * @var VersionComponent Componente de revisión del número de versión.
         * */
        public $Revision;
        private $revision;

        /**
         * Getter for Revision property.
         *
         * @return VersionComponent
         * @see    Version::Revision
         */
        public function getRevision()
        {
            return $this->revision;
        }


        /**
         * Convierte la instancia actual en su representación en cadena.
         * Por defecto, si no están definidos los componentes de compilación y
         * revisión, no se incluyen en la salida.
         * Use el método isValid si quiere determinar si la versión es válida
         * antes de devolver esta cadena.
         *
         * @return string Representación de la versión en forma de cadena:
         *   'major.minor[.build[.revision]]'
         * @see    VersionComponent::isNull
         * @see    Version::isValid
         * */
        public function toString()
        {
            $s[0] = $this->Major;
            $s[1] = $this->Minor;

            if ($this->Revision->IsNotNull()) {
                $s[2] = $this->Build;
                $s[3] = $this->Revision;
            } else {
                if ($this->Build->IsNotNull()) {
                    $s[2] = $this->Build;
                }
            }
            $v = implode('.', $s);

            return $v;
        }

        /**
         * Indica si la instancia actual es un número de versión válido.
         *
         * Se considera válido si:
         * 1. Major o Minor es mayor a cero (0). No puede ser '0.0'.
         * 2. Build y Revision son nulos (no están definidos).
         * 3. Build está definido pero Revision no.
         * 4. Ambos están definidos, pero no poseen la parte de la cadena.
         * 5. Ambos están definidos, pero Build no posee la parte de cadena.
         * 6. Build está definido y tiene la cadena, pero Revision no está definido.
         * 7. Revision posee cadena, pero Build no.
         *
         * @return boolean Un valor que indica si la instancia actual es válida.
         * */
        public function isValid()
        {
            // Validación de Major y Minor:
            $r = ($this->Major > 0 or $this->Minor > 0); //#1

            // Validación de Build y Revision:
            if ($r) {
                $r = ($this->Build->IsNull() and $this->Revision->IsNull()); // #2

                if (!$r) {
                    if ($this->Build->IsNotNull() and $this->Revision->IsNotNull()) {
                        // Si ambos están definidos...

                        $r = (bool) ($this->Build->StringValue == ''); //#5

                        if (!$r) {
                            //#4
                            $r = (bool) (($this->Build->StringValue == '') and ($this->Revision->StringValue == ''));

                            if (!$r) {
                                if ($this->Build->StringValue != '') {
                                    $r = $this->Revision->IsNull(); #6
                                }

                                if ($this->Revision->StringValue != '') {
                                    $r = ($this->Build->StringValue == ''); #7
                                }
                            }
                        }
                    } else {
                        $r = ($this->Build->IsNotNull() and $this->Revision->IsNull()); //#3
                    }
                }
            }

            return (bool) $r;
        }

        /**
         * Determina si el objeto $other especificado es igual a la instancia actual.
         *
         * @param Version $other El otro objeto a comparar.
         *
         * @return bool `true` si $other es igual esta instancia; caso contrario,
         *   `false`.
         * */
        public function equals($other)
        {
            if ($other instanceof Version) {
                if ($this->Major == $other->Major && $this->Minor == $other->Minor) {
                    if ($this->Build->equals($other->Build)) {
                        if ($this->Revision->equals($other->Revision)) {
                            return true;
                        }
                    }
                }
            }

            return false;
        }


        #region IComparable

        /**
         * Determina la posición relativa de esta instancia con respecto al objeto especificado.
         *
         * For types different than ``Version``:
         * - ``integer`` and ``null`` are always < 0;
         * - ``string`` and ``array`` are parsed and then evaluated (if is not parseable, always > 0);
         * - other types are always > 0
         *
         * @param Version|int|string|mixed $other
         *   The other object to compare with.
         *
         * @return integer|null
         *   Returns:
         *   - ``= 0`` if this instance is considered equivalent to $other;
         *   - ``> 0`` si esta instancia se considera mayor a $other;
         *   - ``< 0`` si esta instancia se considera menor a $other.
         *   - ``null`` if this instance can't be compared against $other .
         * @see Object::compare()
         * */
        public function compareTo($other)
        {
            $r = $this->equals($other) ? 0 : 9999;

            if (!($other instanceof Version)) {
                switch (typeof($other)->toString()) {
                    case 'integer':
                    case 'float':
                    case 'double':
                    case 'null':
                    case 'NULL':
                        $r = 1; // Siempre es mayor a cualquier número o null
                        break;

                    case 'string':
                    case 'array':
                        // Se tratan de convertir las cadenas y arrays
                        try {
                            $tmp = Version::parse($other);
                            $r = $this->compareTo($tmp);
                        } catch (InvalidArgumentException $e) {
                            // Siempre es mayor a strings o arrays que no se puedan convertir
                            $r = 1;
                        }
                        break;

                    default:
                        // No se puede determinar comparando a otros objetos.
                        $r = null;
                }

                return $r;
            }

            if ($r != 0) {
                $r = $this->Major - $other->Major;

                if ($r == 0) {
                    $r = $this->Minor - $other->Minor;

                    if ($r == 0) {
                        $r = $this->Build->compareTo($other->Build);

                        if ($r == 0) {
                            $r = $this->Revision->compareTo($other->Revision);
                        }
                    }
                }
            }

            return $r;
        }

        #endregion
    }
}
