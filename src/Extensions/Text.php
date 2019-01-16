<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2015-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */
namespace NelsonMartell\Extensions;

use InvalidArgumentException;

use Cake\Utility\Text as TextBase;

use NelsonMartell\IComparer;
use NelsonMartell\StrictObject;

use function NelsonMartell\msg;
use function NelsonMartell\typeof;

/**
 * Provides extension methods to handle strings.
 * This class is based on \Cake\Utility\Text of CakePHP(tm) class.
 *
 * @since 0.7.0
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @see \Cake\Utility\Text::insert()
 * @link http://book.cakephp.org/3.0/en/core-libraries/text.html
 * */
class Text extends TextBase implements IComparer
{

    /**
     * Replaces format elements in a string with the string representation of an
     * object matching the list of arguments specified. You can give as many
     * params as you need, or an array with values.
     *
     * ##Usage
     * Using numbers as placeholders (encloses between `{` and `}`), you can get
     * the matching string representation of each object given. Use `{0}` for
     * the fist object, `{1}` for the second, and so on:
     *
     * ```php
     * $format = '{0} is {1} years old, and have {2} cats.';
     * echo Text::format($format, 'Bob', 65, 101); // 'Bob is 65 years old, and have 101 cats.'
     * ```
     *
     * You can also use an array to give objects values:
     *
     * ```php
     * $format = '{0} is {1} years old, and have {2} cats.';
     * $data   = ['Bob', 65, 101];
     * echo Text::format($format, $data); // 'Bob is 65 years old, and have 101 cats.'
     * ```
     *
     * This is specially useful to be able to use non-numeric placeholders (named placeholders):
     *
     * ```php
     * $format = '{name} is {age} years old, and have {n} cats.';
     * $data = ['name' => 'Bob', 'n' => 101, 'age' => 65];
     * echo Text::format($format, $data); // 'Bob is 65 years old, and have 101 cats.'
     * ```
     *
     * For numeric placeholders, yo can convert the array into a list of arguments.
     *
     * ```php
     * $format = '{0} is {1} years old, and have {2} cats.';
     * $data   = ['Bob', 65, 101];
     * echo Text::format($format, ...$data); // 'Bob is 65 years old, and have 101 cats.'
     * ```
     *
     * > Note: If objects are not convertible to string, it will throws and catchable exception
     * (`InvalidArgumentException`).
     *
     * @param string      $format An string containing variable placeholders to be replaced. If you provide name
     *   placeholders, you must pass the target array as
     * @param array|mixed $args   Object(s) to be replaced into $format placeholders.
     *   You can provide one item only of type array for named placeholders replacement. For numeric placeholders, you
     *   can still pass the array or convert it into arguments by using the '...' syntax instead.
     *
     * @return string
     * @throws InvalidArgumentException if $format is not an string or placeholder values are not string-convertibles.
     * @todo   Implement formatting, like IFormatProvider or something like that.
     * @author Nelson Martell <nelson6e65@gmail.com>
     */
    public static function format($format, ...$args)
    {
        static $options = [
            'before'  => '{',
            'after'   => '}',
        ];

        $originalData = $args;

        // Make it compatible with named placeholders along numeric ones if passed only 1 array as argument
        if (count($args) === 1 && is_array($args[0])) {
            $originalData = $args[0];
        }

        $data = [];
        // Sanitize values to be convertibles into strings
        foreach ($originalData as $placeholder => $value) {
            $valueType = typeof($value);

            if ($valueType->canBeString() === false) {
                $msg = 'Value for "{{0}}" placeholder is not convertible to string; "{1}" type given.';
                throw new InvalidArgumentException(msg($msg, $placeholder, $valueType));
            }

            // This is to work-arround a bug in use of ``asort()`` function in ``Text::insert`` (at v3.2.5)
            // without SORT_STRING flag... by forcing value to be string.
            settype($value, 'string');
            $data[$placeholder] = $value;
        }

        return static::insert($format, $data, $options);
    }

    /**
     * Ensures that object given is not null. If is `null`, throws and exception.
     *
     * @param mixed $obj Object to validate
     *
     * @return mixed Same object
     * @throws InvalidArgumentException if object is `null`.
     */
    public static function ensureIsNotNull($obj)
    {
        if (is_null($obj)) {
            $msg = msg('Provided object must not be NULL.');
            throw new InvalidArgumentException($msg);
        }

        return $obj;
    }

    /**
     * Ensures that object given is an string. Else, thows an exception
     *
     * @param mixed $obj Object to validate.
     *
     * @return string Same object given, but ensured that is an string.
     * @throws InvalidArgumentException if object is not an `string`.
     */
    public static function ensureIsString($obj)
    {
        if (!is_string(static::ensureIsNotNull($obj))) {
            $msg = msg('Provided object must to be an string; "{0}" given.', typeof($obj));
            throw new InvalidArgumentException($msg);
        }

        return $obj;
    }

    /**
     * Ensures that given string is not empty.
     *
     * @param string $string String to validate.
     *
     * @return string Same string given, but ensured that is not empty.
     * @throws InvalidArgumentException if string is null or empty.
     */
    public static function ensureIsNotEmpty($string)
    {
        if (static::ensureIsString($string) === '') {
            $msg = msg('Provided string must not be empty.');
            throw new InvalidArgumentException($msg);
        }

        return $string;
    }

    /**
     * Ensures that given string is not empty or whitespaces.
     *
     * @param string $string String to validate.
     *
     * @return string Same string given, but ensured that is not whitespaces.
     * @throws InvalidArgumentException if object is not an `string`.
     * @see    \trim()
     */
    public static function ensureIsNotWhiteSpaces($string)
    {
        if (trim(static::ensureIsNotEmpty($string)) === '') {
            $msg = msg('Provided string must not be white spaces.');
            throw new InvalidArgumentException($msg);
        }

        return $string;
    }

    /**
     * Ensures that an string follows the PHP variables naming convention.
     *
     * @param string $string String to be ensured.
     *
     * @return string
     * @throws InvalidArgumentException if object is not an `string` or do not
     *   follows the PHP variables naming convention.
     *
     * @see PropertyExtension::ensureIsValidName()
     */
    public static function ensureIsValidVarName($string)
    {
        $pattern = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/';

        if (!preg_match($pattern, static::ensureIsString($string))) {
            $msg = msg('Provided string do not follows PHP variables naming convention: "{0}".', $string);
            throw new InvalidArgumentException($msg);
        }

        return $string;
    }


    /**
     * {@inheritDoc}
     *
     * This methods is specific for the case when one of them are `string`. In other case, will fallback to
     * `Objects::compare()`.` You should use it directly instead of this method as comparation function
     * for `usort()`.
     *
     * @param string|mixed $left
     * @param string|mixed $right
     *
     * @return int|null
     *
     * @since 1.0.0
     * @see Objects::compare()
     */
    public static function compare($left, $right)
    {
        if (is_string($left)) {
            if (typeof($right)->isCustom()) { // String are minor than classes
                return -1;
            } elseif (typeof($right)->canBeString()) {
                return strnatcmp($left, $right);
            } else {
                return -1;
            }
        } elseif (is_string($right)) {
            $r = static::compare($right, $left);

            if ($r !== null) {
                $r *= -1; // Invert result
            }

            return $r;
        }

        return Objects::compare($left, $right);
    }
}
