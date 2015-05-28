<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition:  [NelsonMartell]  PropertiesHandler
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      v0.5.0
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell {

    use \BadMethodCallException;


    /**
     * Permite encapsular propiedades para usar setters y getters automáticamente.
     * Por defecto, esta funcionalidad viene por defecto en la clase Object.
     *
     *
     *
     * @author  Nelson Martell <nelson6e65-dev@yahoo.es>
      * */
    trait PropertiesHandler
    {
        /**
         * Prefix for methods witch get properties value.
         * You can override to use another prefix.
         * @var string
         */
        const GETTER_PREFIX = 'get';

        /**
         * Prefix for methods witch set properties value.
         * You can override to use another prefix.
         * @var string
         */
        const SETTER_PREFIX = 'set';

        /**
         * Obtiene el valor de una propiedad. Ésta debe definir un método getter, que sigue este
         * modelo: 'get_' + $name + '()'.
         * Restringe la obtención de una propiedad no definida dentro de la clase si no posee su
         * método getter.
         *
         *
         * */
        public function __get($name)
        {
            $error = false;

            if (!property_exists($this, $name)) {
                $error = dgettext('nml', 'Property do not exists').'.';
            }

            $getter = 'get'.$name;

            if (!$error) {
                if (!method_exists($this, $getter)) {
                    $error = dgettext('nml', 'Property is write only').'.'; //?
                }
            }

            if ($error) {
                throw new BadMethodCallException(
                    sprintf(
                        dgettext(
                            'nml',
                            "Unable to access to '%s' property in '%s' class. Reason: %s"
                        ),
                        $name,
                        $this->GetType()->Name,
                        $error
                    )
                );
            }

            return $this->$getter();
        }

        /**
         * Establece el valor de una propiedad según el modelo: 'set_' + $name + '(' + $value + ')'
         * Restringe la asignación de una propiedad no definida dentro de la clase si no posee su
         * método setter.
         *
         *
         * */
        public function __set($name, $value)
        {
            $error = false;

            if (!property_exists($this, $name)) {
                $error = dgettext('nml', 'Property do not exists').'.';
            }

            $setter = 'set'.$name;

            if (!$error) {
                if (!method_exists($this, $setter)) {
                    //La propiedad existe, pero no tiene establecido el método setter.
                    $error = dgettext('nml', 'Property is read only').'.';
                }
            }

            if ($error) {
                throw new BadMethodCallException(
                    sprintf(
                        dgettext(
                            'nml',
                            "Unable to assign '%s' property in '%s' class. Reason: %s"
                        ),
                        $name,
                        $this->GetType()->Name,
                        $error
                    )
                );
            }

            $this->$setter($value);
        }

    }
}
