<?php
/**
 * PHP class «Collection»
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
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
	use NelsonMartell\Object;

	/**
	 * Implementa los métodos de la interfaz Iterator para una colección de objetos.
	 *
	 * @package  NelsonMartell.Collections
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	trait CollectionIterator {
		private $_iteratorPosition = 0;

		public function current() {
			return $this->GetItem($this->_iteratorPosition);
		}

		public function rewind() {
			$this->_iteratorPosition = 0;
		}

		public function key() {
			return $this->_iteratorPosition;
		}

		public function next() {
			++$this->_iteratorPosition;
		}

		public function valid() {
			$v = (bool) ($this->GetItem($this->_iteratorPosition) != null);
			return $v;
		}

		protected abstract function GetItem($index);
	}

	/**
	 * Clase base de una colección de objetos, que provee una implementación predeterminada de la
	 * interfaz ICollection.
	 *
	 * @package  NelsonMartell.Collections
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	class Collection extends Object implements ICollection {
		use CollectionIterator; //Implementación de la interfaz Iterator

		function __construct() {
			parent::__construct();
			unset($this->Count);
		}

		public final function __invoke($index, $value = null) {
			if ($value == null) {
				return $this->_items[$index];
			}

			$this->SetItem($index, $value);
		}

		private $_items = array();


		/**
		 * Inserta un nuevo elemento a la colección, en el índice especificado.
		 *
		 * @param   integer  $index    Índice del elemento a insertar.
		 * @param   mixed    $newItem  Nuevo elemento a insertar a la colección.
		 * @access  protected
		 * @return  void
		 * */
		protected function InsertItem($index, $newItem) {
			if ($index > $this->Count || $index < 0) {
				throw new OutOfRangeException();
			}

			if ($index == $this->Count){
				$this->_items[$index] = null;
				$this->_count++;
			}

			$this->_items[$index] = $newItem;
		}

		/**
		 * Quita todos los elementos de la colección.
		 *
		 * @return  void
		 * */
		protected function ClearItems() {
			$this->_items = array();
			$this->_count = 0;
		}

		/**
		 * Establece un elemento en el índice especificado.
		 *
		 * @param  integer  $index    Índice del elemento a establecer.
		 * @param  mixed    $newItem  Nuevo valor con el que se va a reemplazar.
		 * @return  void
		 * */
		protected function SetItem($index, $newItem) {
			if ($index >= $this->Count || $index < 0) {
				throw new OutOfRangeException();
			}

			$this->_items[$index] = $newItem;
		}

		/**
		 * Obtiene el elemento almacenado en el índice especificado.
		 * Este método no lanza excepción en caso de indicar un índice fuera del rango; en cambio,
		 * devuelve NULL.
		 * El elemento obtenido es de sólo lectura. Para modificar el elemento dentro de la colección,
		 * tendría que utilizarse el método Collection::SetItem una vez modificado.
		 *
		 * @param   integer  $index  Índice del elemento a obtener.
		 * @return  mixed
		 * */
		protected function GetItem($index) {
			if ($index >= $this->Count || $index < 0) {
				return null;
			}

			return $this->_items[$index];
		}

		protected function RemoveItem($index) {
			if ($index >= $this->Count || $index < 0) {
				throw new OutOfRangeException();
			}

			for($i = $index; $i < $this->Count - 1; $i++) {
				$this->_items[$i] = $this->_items[$i + 1]; //Mueve los valores
			}

			unset($this->_items[$this->Count - 1]); //Des-asigna el último elemento

			$this->_count--;
		}

		/**
		 * Obtiene la representación en cadena de esta colección.
		 *
		 * @return  string
		 * */
		public function ToString() {
			$t = $this->GetType();

			$s = '(' . $t->Name . '): { ';

			foreach ($this->_items as $item) {
				$s .= $item . ', ';
			}

			$s .= '}';

			return $s;

		}


		#region {Implementación de la interfaz ICollection}

		/**
		 * Obtiene el número de elementos incluidos en la colección.
		 * Ésta propiedad es de sólo lectura.
		 *
		 * @var  integer
		 * */
		public $Count;
		private $_count = 0;

		/**
		 * Obtiene el número de elementos incluidos en la colección.
		 *
		 * @return  integer
		 * */
		public function get_Count() {
			return $this->_count;
		}

		/**
		 * Agrega un nuevo elemento al final de la colección.
		 * Nota para herederos: Para cambiar el comportamiento de este método, reemplazar más bien
		 * el método protegido 'InsertItem'.
		 *
		 * @param   mixed  Elemento que se va a agregar a la colección.
		 * @return  void
		 * */
		public function Add($item) {
			$this->InsertItem($this->Count, $item);
		}

		/**
		 * Quita todos los elementos de la colección.
		 * Nota para herederos: Para cambiar el comportamiento de este método, reemplazar más bien
		 * el método protegido 'ClearItems'.
		 *
		 * @return  void
		 * */
		public function Clear() {
			$this->ClearItems();
		}

		/**
		 * Determina si la colección contiene al elemento especificado.
		 *
		 * @param   mixed   $item Objeto que se va a buscar.
		 * @return  boolean true si $item se encuentra; en caso contrario, false.
		 * */
		public function Contains($item) {
			foreach($this->_items as $i) {
				if ($item === $i) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Quita, si existe, la primera aparición de un objeto específico de la colección.
		 *
		 * @param   mixed   $item Objeto que se va a quitar.
		 * @return  boolean True si $item se ha quitado correctamente; en caso contrario, False.
		 *   Este método también devuelve false si no se encontró $item.
		 * */
		public function Remove($item) {
			for ($i = 0; $i < $this->Count; $i++) {
				if ($this->_items[$i] === $item) {
					$this->RemoveItem($i);
				}
			}

			return false;
		}

		#end region


	}
}
