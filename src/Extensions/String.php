<?php
/**
 * PHP: Nelson Martell Library file
 *
 * File info:
 * - Namespace: NelsonMartell\Extensions
 * - Content:   Class definition
 *
 * Copyright © 2015 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright © 2015 Nelson Martell
 * @link       http://nelson6e65.github.io/php_nml/
 * @since      0.4.1
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */
namespace NelsonMartell\Extensions;

/**
 * Provides extension methods to handle strings.
 *
 *
 * @copyright  This class is based on Cake\Utility\String of CakePHP(tm) class.
 * @see  Original DOC of String based on: http://book.cakephp.org/3.0/en/core-libraries/string.html
 * */
class String extends \Cake\Utility\String {

	/**
	 * Replaces format elements in a string with the string representation of an object matching the
	 * list of arguments specified. You can give as many params as you need, or an array with values.
	 *
	 * ##Usage
	 * Using numbers as placeholders (encloses between `{` and `}`), you can get the matching string
	 * representation of each object given. Use `{0}` for the fist object, `{1}` for the second,
	 *  and so on.
	 * Example: `String::Format('{0} is {1} years old, and have {2} cats.', 'Bob', 65, 101);`
	 * Returns: 'Bob is 65 years old, and have 101 cats.'
	 *
	 * You can also use an array to give objects values.
	 * Example: `String::Format('{0} is {1} years old.', ['Bob', 65, 101]);`
	 * Returns: 'Bob is 65 years old, and have 101 cats.'
	 *
	 * If give an key => value array, each key stands for a placeholder variable name to be replaced
	 * with value key. In this case, order of keys do not matter.
	 * Example:
	 * `$arg0 = ['name' => 'Bob', 'n' => 101, 'age' => 65];`
	 * `$format = '{name} is {age} years old, and have {n} cats.';`
	 * `String::Format($format, $arg0);`
	 * Returns: 'Bob is 65 years old, and have 101 cats.'
	 *
	 *
	 * @param   string       $format  A string containing variable placeholders.
	 * @param   array|mixed  $arg0  Object(s) to be replacen into $format placeholders.
	 * @return  string
	 * @todo  Implement php.net/functions.arguments.html#functions.variable-arg-list.new for PHP 5.6+
	 * @todo  Implement formatting, like IFormatProvider or something like that.
	 */
	public static function Format($format, $arg0) {
		static $options = [
			'before'	=> 	'{',
			'after' 	=> 	'}',
		];

		$data = [];

		//Carga de argumentos, compatible con PHP < 5.6
		$nArgs = func_num_args();

		if ($nArgs > 2) {
			$args = func_get_args();

			foreach ($args as $index => $arg) {
				if ($index == 0) { continue; }

				$data[] = $arg;
			}
		} else {
			$data = $arg0;
		}

		return parent::insert($format, $data, $options);
	}

}
