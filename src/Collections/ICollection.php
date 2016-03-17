<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Interface definition:  [NelsonMartell\Collections]  ICollection
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

namespace NelsonMartell\Collections {

    use \Iterator;

    /**
     * Define métodos para manipular colecciones de objetos.
     *
     * @author Nelson Martell <nelson6e65-dev@yahoo.es>
     * */
    interface ICollection extends Iterator
    {


        /**
         * Obtiene el número de elementos incluidos en la colección.
         * Si extiende la clase NelsonMartell.Object, puede accederse desde la
         * propiedad `Count`.
         *
         * @return integer
         * @see    NelsonMartell\Object
         * */
        public function getCount();


        /**
         * Agrega un elemento a la colección.
         *
         * @param mixed $item Objeto que se va a agregar.
         *
         * @return void
         * */
        public function add($item);


        /**
         * Quita todos los elementos de la colección.
         * La propiedad Count se debe establecer en 0 y deben liberarse las
         * referencias a otros objetos desde los elementos de la colección.
         *
         * @return void
         * */
        public function clear();


        /**
         * Determina si la colección contiene al elemento especificado.
         *
         * @param mixed $item Objeto que se va a buscar.
         *
         * @return boolean `true` si $item se encuentra; en caso contrario, `false`.
         * */
        public function contains($item);


        /**
         * Quita, si existe, la primera aparición de un objeto específico de la
         * colección.
         *
         * @param mixed $item Objeto que se va a quitar.
         *
         * @return boolean `true` si el elemento se ha quitado correctamente; en
         *   caso contrario, `false`. Este método también devuelve `false` si no
         *   se encontró.
         * */
        public function remove($item);
    }
}
