<?php
/**
 * PHP interface «IList»
 *
 * Copyright © 2015 Nelson Martell (http://fb.me/nelson6e65)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright © 2015 Nelson Martell
 * @link		http://nelson6e65.github.io/php_nml/
 * @package  	NelsonMartell.Collections
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * */


namespace NelsonMartell\Collections {

	/**
	 * Representa una colección de objetos a los que se puede tener acceso por un índice.
	 * 
	 * 
	 * @package  NelsonMartell.Collections
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 *
	 * */
	interface IList extends ICollection {

		/**
		 * Determina el índice de un elemento específico de la lista.
		 * Si un objeto aparece varias veces en la lista, el método IndexOf siempre devolverá la
		 * primera instancia encontrada.
		 * 
		 * 
		 * @param   mixed $item Objeto que se va a buscar.
		 * @return  integer Índice de $item si se encuentra en la lista; en caso contrario, -1.
		 * */
		public function IndexOf($item);

		/**
		 * Inserta un elemento en la lista, en el índice especificado.
		 * 
		 * 
		 * @param  integer $index Índice de base cero en el que debe insertarse $item.
		 * @param   mixed $item Objeto que se va a insertar.
		 *
		 * */
		public function Insert($index, $item);

		/**
		 * Quita el elemento del índice especificado.
		 * 
		 * 
		 * @param  integer $index Índice de base cero del elemento que se va a quitar.
		 * */
		public function RemoveAt($index);

	}
}
