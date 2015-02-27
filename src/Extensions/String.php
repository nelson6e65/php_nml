<?php
/**
 * PHP: Nelson Martell Library
 *
 * File info:
 * - Namespace:    NelsonMartell\Extensions
 * - Content:      Class definition for String
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
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License (MIT) *
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
	 * Replaces variable placeholders inside a $str with any given $data. Each key in the $data array
	 * corresponds to a variable placeholder name in $str.
	 * Example: `String::Format('{name} is {age} years old.', ['name' => 'Bob', 'age' => '65']);`
	 * Returns: `Bob is 65 years old.´
	 *
	 * You can use also numbers as placeholders from and array without keys. The last example:
	 * `String::Format('{0} is {1} years old.', ['Bob', '65']);`
	 *
	 * Using numbers, you can also pass a list of arguments after $str. The first arg after $str,
	 * is for {0}, the second, {1}, and so:
	 * Example: `String::Format('{0} is {1} years old, and have {2} cats.', 'Bob', 65, 101);`
	 * Returns: `Bob is 65 years old, and have 101 cats.`
	 *
	 *
	 * @param  string  $str A string containing variable placeholders.
	 * @param  array|mixed  $data A key => val array where each key stands for a placeholder variable
	 *     name to be replaced with val. | arg0: first object (index 0) for {0} placeholder (can be
	 *     followed by arg1, arg2, ..., argn).
	 * @return  string
	 * @todo  Implement php.net/functions.arguments.html#functions.variable-arg-list.new for PHP 5.6+
	 * @todo  Implement formatting, like IFormatProvider or something like that.
	 */
	public static function Format($str, $data) {
		static $options = [
			'before'	=> 	'{',
			'after' 	=> 	'}',
		];

		//Carga de argumentos, compatible con PHP < 5.6
		$nArgs = func_num_args();

		if ($nArgs > 2) {
			$args = func_get_args();
			$data = [];

			foreach ($args as $index => $arg) {
				if ($index == 0) { continue; }

				$data[] = $arg;
			}
		}

		return parent::insert($str, $data, $options);
	}

}
