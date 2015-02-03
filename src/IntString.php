<?php
/**
 * PHP class «IntString»
 *
 * Copyright © 2015 Nelson Martell (http://fb.me/nelson6e65)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright © 2015 Nelson Martell
 * @link		http://nelson6e65.github.io/php_nml/
 * @package  	NelsonMartell
 * @license  	http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * */

namespace NelsonMartell {

	/**
	 * Representa un elemento mixto, compuesto por un entero y una cadena unidos (en ese orden).
	 * El método ToString obtiene esa cadena compuesta.
	 *
	 *
	 * @package  NelsonMartell
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	class IntString extends Object implements IEquatable, IComparable {

		function __construct($intValue = 0, $stringValue = '') {
			unset($this->IntValue, $this->StringValue);

			$this->_intValue = (int) $intValue;
			$this->_stringValue = (string) $stringValue;
		}

		public static function Parse($parseableString) {
			$s = new IntString();

			if (typeof($parseableString) == $s->GetType()) {
				return $parseableString;
			}


			$s = (string) $parseableString;
			$intValue = (int) $s;

			$stringValue = explode($intValue, $s, 2);

			if ($intValue) {
				$stringValue = $stringValue[1];
			} else {
				$stringValue = $stringValue[0];
			}

			return new IntString($intValue, $stringValue);
		}


		private $_intValue = 0;
		private $_stringValue = '';

		public $IntValue;
		public function get_IntValue() {
			return $this->_intValue;
		}

		public $StringValue;
		public function get_StringValue() {
			return $this->_stringValue;
		}

		public function ToString() {
			return $this->IntValue . $this->StringValue;
		}

		public function Equals($other) {
			if ($other instanceof IntString) {
				if ($this->IntValue == $other->IntValue) {
					if ($this->StringValue == $other->StringValue) {
						return true;
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
		 * @param   IntString  $other
		 * @return  integer  0, si es igual; >0, si es mayor; <0, si es menor.
		 * */
		public function CompareTo($other){

			$r = $this->Equals($other) ? 0 : 9999;

			if ($r != 0) {
				$r = $this->IntValue - $other->IntValue;

				if ($r == 0) {
					$r = $this->StringValue < $other->StringValue ? -1 : 1;
				}
			}

			return $r;
		}

		#endregion

	}
}
