<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  Version
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
     * Representa el número de versión de un programa o ensamblado, de la forma "1.2.3.4". Sólo
     * siendo obligatorios el primer y segundo componente.
     * No se puede heredar esta clase.
     *
     *
     * @author  Nelson Martell <nelson6e65-dev@yahoo.es>
     * */
    final class Version extends Object implements IEquatable, IComparable
    {

        /**
         * Crea una nueva instancia con los números principal, secundario, de compilación (opcional)
         * y revisión (opcional).
         * Para comprobar si la versión es válida, usar el método IsValid.
         *
         *
         * @param  int  $major  Componente principal
         * @param  int  $minor  Componente secundario
         * @param  int|string|VersionComponent|NULL  $build  Componente de compilación
         * @param  int|string|VersionComponent|NULL  $revision  Componente de revisión
         * @throw  InvalidArgumentException
         * */
        public function __construct($major, $minor, $build = null, $revision = null)
        {
            parent::__construct();
            unset($this->Major, $this->Minor, $this->Build, $this->Revision);

            if (!is_integer($major)) {
                $args = [
                    'class'    => $this->getType()->Name,
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
                    'class'    => $this->getType()->Name,
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
         *
         * @param   string  Cadena a convertir.
         * @return  Version Objeto convertido desde $value.
         * */
        public static function parse($value)
        {
            if ($value instanceof Version) {
                return $value;
            }

            $version = (string) $value;

            $version = explode('.', $version);

            $c = count($version);

            if ($c > 4 || $c < 2) {
                //var_dump($version);
                throw new InvalidArgumentException(
                    sprintf(
                        dgettext(
                            'nml',
                            "Unable to parse. Argument passed has an invalid format: '%s'."
                        ),
                        $value
                    )
                );
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
         * Obtiene el valor del componente principal del número de versión del objeto actual.
         * Ésta propiedad es de sólo lectura.
         *
         *
         * @var  int Componente principal del número de versión
         * */
        public $Major;
        private $major;

        public function getMajor()
        {
            return $this->major;
        }


        /**
         * Obtiene el valor del componente secundario del número de versión del objeto actual.
         * Ésta propiedad es de sólo lectura.
         *
         *
         * @var  int Componente secundario del número de versión
         * */
        public $Minor;
        private $minor;

        public function getMinor()
        {
            return $this->minor;
        }

        /**
         * Obtiene el valor del componente de compilación del número de versión del objeto actual.
         * Ésta propiedad es de sólo lectura.
         *
         *
         * @var  VersionComponent  Componente de compilación del número de versión
         * */
        public $Build;
        private $build;

        public function getBuild()
        {
            return $this->build;
        }

        /**
         * Obtiene el valor del componente de revisión del número de versión del objeto actual.
         * Ésta propiedad es de sólo lectura.
         *
         *
         * @var  VersionComponent  Componente de revisión del número de versión
         * */
        public $Revision;
        private $revision;

        public function getRevision()
        {
            return $this->revision;
        }


        /**
         * Convierte la instancia actual en su representación en cadena.
         * Por defecto, si no están definidos los componentes de compilación y revisión, no se
         * incluyen en la salida.
         * Use el método IsValid si quiere determinar si la versión es válida antes de devolver esta cadena.
         *
         *
         * @return  string  Representación de la versión en forma de cadena: 'major.minor[.build[.revision]]'
         * @see  VersionComponent::IsNull
         * @see  Version::IsValid
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
         * @return  boolean  Un valor que indica si la instancia actual es válida.
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
         *
         * @param Version $other
         * @return  bool True si $other es igual esta instancia
         * */
        public function equals($other)
        {
            if ($other instanceof Version) {
                if ($this->Major == $other->Major && $this->Minor == $other->Minor) {
                    if ($this->Build->Equals($other->Build)) {
                        if ($this->Revision->Equals($other->Revision)) {
                            return true;
                        }
                    }
                }
            }

            return false;
        }


        #region IComparable

        /**
         * Determina la posición relativa del objeto especificado con respecto a esta instancia.
         *
         *
         * @param   Version  $other
         * @return  integer  0, si es igual; >0, si es mayor; <0, si es menor.
         * */
        public function compareTo($other)
        {

            $r = $this->Equals($other) ? 0 : 9999;

            if ($r != 0) {
                $r = $this->Major - $other->Major;

                if ($r == 0) {
                    $r = $this->Minor - $other->Minor;

                    if ($r == 0) {
                        $r = $this->Build->CompareTo($other->Build);

                        if ($r == 0) {
                            $r = $this->Revision->CompareTo($other->Revision);
                        }
                    }
                }
            }

            return $r;
        }

        #endregion
    }
}
