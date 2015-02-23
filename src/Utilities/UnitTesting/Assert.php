<?php
/**
 * PHP class «Assert»
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @package    NelsonMartell.Utilities.UnitTesting
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 *
 * */

namespace NelsonMartell\Utilities\UnitTesting {
	use NelsonMartell\Object;
	use NelsonMartell\Version;
	use \Exception;

	/**
	 * Comprueba condiciones de pruebas.
	 *
	 *
	 * @package  NelsonMartell.Utilities.UnitTesting
	 * @author   Nelson Martell (@yahoo.es: nelson6e65-dev)
	 * */
	final class Assert {

		private static function Equals($expected, $actual) {
			if ($expected === $actual) {
				return true;
			}

			if ($expected instanceof Object || $expected instanceof IEquatable) {
				if ($expected->Equals($actual)) {
					return true;
				}
			} else {
				if ($expected == $actual) {
					return true;
				}
			}

			return false;
		}


		/**
		 * Comprueba si los dos objetos especificados son iguales. Caso contrario, emite una
		 * advertencia.
		 *
		 *
		 * @param   string $msg Custom message to append on assert failed.
		 * @return  boolean true si son iguales; false, en caso contrario.
		 * */
		public static function AreEqual($expected, $actual, $msg = '') {

			$equals = self::Equals($expected, $actual);

			if (!$equals) {
				$a_string = $actual;
				$e_string = $expected;

				if (is_array($actual)) {
					$a_string = implode(', ', $actual);
				}

				if (is_array($expected)) {
					$e_string = implode(', ', $expected);
				}

				if (is_bool($actual)) {
					$a_string = $actual ? 'true' : 'false';
				}

				if (is_bool($expected)) {
					$e_string = $expected ? 'true' : 'false';
				}

				$error = sprintf(_('%5$s failed. Expected: (%3$s) "%4$s". Actual: (%1$s) "%2$s".'), typeof($actual), $a_string, typeof($expected), $e_string, __METHOD__);

				if ($msg) {
					$error .= ' ' . sprintf(_('Message: %s'), $msg);
				}

				trigger_error($error, E_USER_WARNING);
			}

			return $equals;
		}



		/**
		 * Comprueba si los dos objetos especificados NO son iguales. En caso de que sí lo sean,
		 * emite una advertencia.
		 *
		 *
		 * @param  string $msg Custom message to append on assert failed.
		 * @return  boolean true si NO son iguales; false, en caso contrario.
		 * */
		public static function AreNotEqual($notExpected, $actual, $msg = '') {
			$not_equals = !self::Equals($notExpected, $actual);

			if (!$not_equals) {
				$a_string = $actual;
				$ne_string = $notExpected;

				if (is_array($actual)) {
					$a_string = implode(', ', $actual);
				}

				if (is_array($notExpected)) {
					$ne_string = implode(', ', $notExpected);
				}

				if (is_bool($actual)) {
					$a_string = $actual ? 'true' : 'false';
				}

				if (is_bool($notExpected)) {
					$ne_string = $notExpected ? 'true' : 'false';
				}

				$error = sprintf(_('%5$s failed. Not expected: (%3$s) "%4$s". Actual: (%1$s) "%2$s".'), Type::typeof($actual), $a_string, Type::typeof($notExpected), $ne_string, __METHOD__);

				if ($msg) {
					$error .= ' ' . sprintf(_('Message: %s'), $msg);
				}

				trigger_error($error, E_USER_WARNING);
			}

			return $not_equals;
		}


		public static function IsTrue($actual) {
			return self::AreEqual(true, $actual);
		}

		public static function IsFalse($actual) {
			return self::AreEqual(false, $actual);
		}

		/**
		 * Comprueba que, si al llamar un método público de un objeto, se obtiene una excepción del
		 * tipo especificado.
		 *
		 *
		 * @param   string $method_name Method name.
		 * @param   mixed $obj Object to check.
		 * @param   array $params Method params.
		 * @param   Exception $expectedException Exception to check type. If null, checks any.
		 * @param   string $msg Custom message to append on assert failed.
		 * @return  boolean
		 * */
		public static function MethodThrowsException($method_name, $obj, $params = array(), Exception $expectedException = null, $msg = '') {

			$equals = false;

			$expected = typeof($expectedException);
			$actual = typeof(null);

			try {
				call_user_func_array(array($obj, $method_name), $params);
			} catch (Exception $e) {
				$actual = typeof($e);
			}

			if ($actual->IsNotNull()) {
				// Se lanzó la excepción...
				if ($expected->IsNull()) {
					// ...pero no se especificó el tipo de excepción, es decir, puede ser cualquiera
					$equals = true;
				} else {
					// ...pero debe comprobarse si son del mismo tipo:
					$equals = self::Equals($expected, $actual);

					if (!$equals) {
						$error = sprintf(_('%1$s failed. Expected: "%2$s". Actual: "%3$s".'), __METHOD__, $expected, $actual);

						if ($msg) {
							$error .= ' ' . sprintf(_('Message: %s'), $msg);
						}

						trigger_error($error, E_USER_WARNING);
					}
				}
			} else {
				// No se lanzó la excepción
				$actual = "No exception";

				if ($expected->IsNull()) {
					$expected = "Any exception";
				}

				$error = sprintf(_('%1$s failed. Expected: "%2$s". Actual: "%3$s".'), __METHOD__, $expected, $actual);

				if ($msg) {
					$error .= ' ' . sprintf(_('Message: %s'), $msg);
				}

				trigger_error($error, E_USER_WARNING);
			}


			return $equals;
		}



		public static function PropertyThrowsException($obj, $property_name, $value, Exception $expectedException = null, $msg = '') {
			$equals = false;

			$expected = typeof($expectedException);
			$actual = typeof(null);

			try {
				$obj->$property_name = $value;
			} catch (Exception $e) {
				$actual = typeof($e);
			}

			if ($actual->IsNotNull()) {
				// Se lanzó la excepción...
				if ($expected->IsNull()) {
					// ...pero no se especificó el tipo de excepción, es decir, puede ser cualquiera
					$equals = true;
				} else {
					// ...pero debe comprobarse si son del mismo tipo:
					$equals = self::Equals($expected, $actual);

					if (!$equals) {
						$error = sprintf(_('%1$s failed. Expected: "%2$s". Actual: "%3$s".'), __METHOD__, $expected, $actual);

						if ($msg) {
							$error .= ' ' . sprintf(_('Message: %s'), $msg);
						}

						trigger_error($error, E_USER_WARNING);
					}
				}
			} else {
				// No se lanzó la excepción
				$actual = "No exception";

				if ($expected->IsNull()) {
					$expected = "Any exception";
				}

				$error = sprintf(_('%1$s failed. Expected: "%2$s". Actual: "%3$s".'), __METHOD__, $expected, $actual);

				if ($msg) {
					$error .= ' ' . sprintf(_('Message: %s'), $msg);
				}

				trigger_error($error, E_USER_WARNING);
			}


			return $equals;
		}

	}
}
