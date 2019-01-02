<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  Version
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
 * Representa el número de versión de un programa o ensamblado, de la forma "1.2.3.4". Sólo
 * siendo obligatorios el primer y segundo componente.
 * No se puede heredar esta clase.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.1.1
 * @property-read int               $major    Obtiene el valor del componente principal del número de versión. Esta
 *   propiedad es de sólo lectura.
 * @property-read int               $minor    Obtiene el valor del componente secundario del número de versión. Esta
 *   propiedad es de sólo lectura.
 * @property-read VersionComponent  $build    Obtiene el valor del componente de compilación del número de versión.
 *   Esta propiedad es de sólo lectura.
 * @property-read VersionComponent  $revision Obtiene el valor del componente de revisión del número de versión. Esta
 *   propiedad es de sólo lectura.
 *
 * */
final class Version extends StrictObject implements IEquatable, IComparable
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

        if (!is_integer($major)) {
            $args = [
                'class'    => typeof($this)->name,
                'name'     => 'major',
                'pos'      => 0,
                'expected' => typeof(0),
                'actual'   => typeof($major),
            ];

            $msg = msg('Invalid argument type.');
            $msg .= msg(
                ' "{name}" (position {pos}) must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );
            $msg .= msg(' Convert value or use the "{class}::parse" (static) method.', $args);

            throw new InvalidArgumentException($msg);
        }

        if (!is_integer($minor)) {
            $args = [
                'class'    => typeof($this)->name,
                'name'     => 'minor',
                'pos'      => 1,
                'expected' => typeof(0),
                'actual'   => typeof($minor),
            ];

            $msg = msg('Invalid argument type.');
            $msg .= msg(
                ' "{name}" (position {pos}) must to be an instance of "{expected}"; "{actual}" given.',
                $args
            );
            $msg .= msg(' Convert value or use the "{class}::parse" (static) method.', $args);

            throw new InvalidArgumentException($msg);
        }

        if ($major < 0) {
            $args = [
                'name'     => 'major',
                'pos'      => 0,
                'actual'   => $major,
            ];

            $msg = msg('Invalid argument value.');
            $msg .= msg(
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

            $msg = msg('Invalid argument value.');
            $msg .= msg(
                ' "{name}" (position {pos}) must to be a positive number; "{actual}" given.',
                $args
            );

            throw new InvalidArgumentException($msg);
        }

        $this->major = $major;
        $this->minor = $minor;
        $this->build = VersionComponent::parse($build);
        $this->revision = VersionComponent::parse($revision);
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
            $msg = msg('Unable to parse. Argument passed has an invalid type: "{0}".', typeof($value));
            throw new InvalidArgumentException($msg);
        }

        // $value ya debería ser un array.
        $c = count($version);

        if ($c > 4 || $c < 2) {
            $msg = msg('Unable to parse. Argument passed has an invalid format: "{0}".', $value);
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

    private $major;

    /**
     * Getter for major property.
     *
     * @return int
     * @see    Version::$major
     */
    protected function getMajor()
    {
        return $this->major;
    }

    private $minor;

    /**
     * Getter for minor property.
     *
     * @return int
     * @see    Version::$minor
     */
    protected function getMinor()
    {
        return $this->minor;
    }

    private $build;

    /**
     * Getter for build property.
     *
     * @return VersionComponent
     * @see    Version::$build
     */
    protected function getBuild()
    {
        return $this->build;
    }

    private $revision;

    /**
     * Getter for revision property.
     *
     * @return VersionComponent
     * @see    Version::$revision
     */
    protected function getRevision()
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
     * @see    VersionComponent::isNull()
     * @see    Version::isValid()
     * */
    public function toString()
    {
        $s[0] = $this->major;
        $s[1] = $this->minor;

        if ($this->revision->isNotNull()) {
            $s[2] = $this->build;
            $s[3] = $this->revision;
        } else {
            if ($this->build->isNotNull()) {
                $s[2] = $this->build;
            }
        }
        $v = implode('.', $s);

        return $v;
    }

    /**
     * Indica si la instancia actual es un número de versión válido.
     *
     * Se considera válido si:
     * 1. major o minor es mayor a cero (0). No puede ser '0.0'.
     * 2. build y revision son nulos (no están definidos).
     * 3. build está definido pero revision no.
     * 4. Ambos están definidos, pero no poseen la parte de la cadena.
     * 5. Ambos están definidos, pero build no posee la parte de cadena.
     * 6. build está definido y tiene la cadena, pero revision no está definido.
     * 7. revision posee cadena, pero build no.
     *
     * @return bool Un valor que indica si la instancia actual es válida.
     * */
    public function isValid()
    {
        // Validación de major y minor:
        $r = ($this->major > 0 or $this->minor > 0); //#1

        // Validación de build y revision:
        if ($r) {
            $r = ($this->build->isNull() and $this->revision->isNull()); // #2

            if (!$r) {
                if ($this->build->isNotNull() and $this->revision->isNotNull()) {
                    // Si ambos están definidos...

                    $r = (bool) ($this->build->stringValue == ''); //#5

                    if (!$r) {
                        //#4
                        $r = (bool) (($this->build->stringValue == '') and ($this->revision->stringValue == ''));

                        if (!$r) {
                            if ($this->build->stringValue != '') {
                                $r = $this->revision->isNull(); #6
                            }

                            if ($this->revision->stringValue != '') {
                                $r = ($this->build->stringValue == ''); #7
                            }
                        }
                    }
                } else {
                    $r = ($this->build->isNotNull() and $this->revision->isNull()); //#3
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
            if ($this->major == $other->major && $this->minor == $other->minor) {
                if ($this->build->equals($other->build)) {
                    if ($this->revision->equals($other->revision)) {
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
     * @return int|null
     *   Returns:
     *   - ``= 0`` if this instance is considered equivalent to $other;
     *   - ``> 0`` si esta instancia se considera mayor a $other;
     *   - ``< 0`` si esta instancia se considera menor a $other.
     *   - ``null`` if this instance can't be compared against $other .
     * @see StrictObject::compare()
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

        if ($r !== 0) {
            $r = $this->major - $other->major;

            if ($r === 0) {
                $r = $this->minor - $other->minor;

                if ($r === 0) {
                    $r = $this->build->compareTo($other->build);

                    if ($r === 0) {
                        $r = $this->revision->compareTo($other->revision);
                    }
                }
            }
        }

        return $r;
    }

    #endregion
}
