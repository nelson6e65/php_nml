<?php
/**
 * PHP class «Objects»
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
	 * Clase base de una colección de objetos, que define métodos y propiedades básicas para
	 * trabajar con colecciones.
	 *
	 *
	 * @package  NelsonMartell.Collections
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	abstract class Objects
		extends Object {


		function __construct() {
			parent::__construct();
			unset($this->Count);
		}

		private $_items = array();

		public $Count;
		private $_count = 0;

		public function get_Count() {
			return $this->_count;
		}




		public final function __invoke($index, $value = null) {
			if ($value == null) {
				return $this->_items[$index];
			}

			$this->SetItem($index, $value);
		}

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

		protected function SetItem($index, $newItem) {

			if ($index >= $this->Count || $index < 0) {
				throw new OutOfRangeException();
			}

			$this->_items[$index] = $newItem;
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

		protected function ClearItems() {
			$this->_items = new array();
			$this->_count = 0;
		}


		public function ToString() {
			$t = $this->GetType();

			$s = $t->Name . ': { ';

			foreach ($this->_items as $item) {
				$s .= $item . ', ';
			}

			$s .= '}';

			return $s;

		}

	}
}
