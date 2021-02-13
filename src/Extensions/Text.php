<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2015-2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Extensions;

use InvalidArgumentException;
use NelsonMartell\IComparer;
use NelsonMartell\StrictObject;

use function NelsonMartell\msg;
use function NelsonMartell\typeof;

/**
 * Provides extension methods to handle strings.
 * This class is based on \Cake\Utility\Text of CakePHP(tm) class.
 *
 * @since 0.7.0
 * @since 1.0.0 Remove `\Cake\Utility\Text` dependency.
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @see \Cake\Utility\Text::insert()
 * @link http://book.cakephp.org/3.0/en/core-libraries/text.html
 * */
class Text implements IComparer
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
     * @param array<int, mixed> $args   Object(s) to be replaced into $format placeholders.
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
            'before' => '{',
            'after'  => '}',
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



    // ########################################################################
    //
    // Methods based on CakePHP Utility (https://github.com/cakephp/utility)
    //
    // Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
    //
    // ========================================================================


    // ========================================================================
    // Cake\Utility\Text
    // ------------------------------------------------------------------------


    /**
     * Replaces variable placeholders inside a $str with any given $data. Each key in the $data array
     * corresponds to a variable placeholder name in $str.
     * Example:
     * ```
     * Text::insert(':name is :age years old.', ['name' => 'Bob', 'age' => '65']);
     * ```
     * Returns: Bob is 65 years old.
     *
     * Available $options are:
     *
     * - before: The character or string in front of the name of the variable placeholder (Defaults to `:`)
     * - after: The character or string after the name of the variable placeholder (Defaults to null)
     * - escape: The character or string used to escape the before character / string (Defaults to `\`)
     * - format: A regex to use for matching variable placeholders. Default is: `/(?<!\\)\:%s/`
     *   (Overwrites before, after, breaks escape / clean)
     * - clean: A boolean or array with instructions for Text::cleanInsert
     *
     * @param string $str A string containing variable placeholders
     * @param array $data A key => val array where each key stands for a placeholder variable name
     *     to be replaced with val
     * @param array $options An array of options, see description above
     * @return string
     */
    public static function insert(string $str, array $data, array $options = []): string
    {
        $defaults = [
            'before' => ':',
            'after'  => '',
            'escape' => '\\',
            'format' => null,
            'clean'  => false,
        ];
        $options += $defaults;
        $format   = $options['format'];
        $data     = $data;
        if (empty($data)) {
            return $options['clean'] ? static::cleanInsert($str, $options) : $str;
        }

        if (!isset($format)) {
            $format = sprintf(
                '/(?<!%s)%s%%s%s/',
                preg_quote($options['escape'], '/'),
                str_replace('%', '%%', preg_quote($options['before'], '/')),
                str_replace('%', '%%', preg_quote($options['after'], '/'))
            );
        }

        if (strpos($str, '?') !== false && is_numeric(key($data))) {
            $offset = 0;
            while (($pos = strpos($str, '?', $offset)) !== false) {
                $val    = array_shift($data);
                $offset = $pos + strlen($val);
                $str    = substr_replace($str, $val, $pos, 1);
            }

            return $options['clean'] ? static::cleanInsert($str, $options) : $str;
        }

        $dataKeys = array_keys($data);
        $hashKeys = array_map('crc32', $dataKeys);
        /** @var array<string, string> $tempData */
        $tempData = array_combine($dataKeys, $hashKeys);
        krsort($tempData);

        foreach ($tempData as $key => $hashVal) {
            $key = sprintf($format, preg_quote($key, '/'));
            $str = preg_replace($key, $hashVal, $str);
        }
        /** @var array<string, mixed> $dataReplacements */
        $dataReplacements = array_combine($hashKeys, array_values($data));
        foreach ($dataReplacements as $tmpHash => $tmpValue) {
            $tmpValue = is_array($tmpValue) ? '' : $tmpValue;
            $str      = str_replace($tmpHash, $tmpValue, $str);
        }

        if (!isset($options['format']) && isset($options['before'])) {
            $str = str_replace($options['escape'] . $options['before'], $options['before'], $str);
        }

        return $options['clean'] ? static::cleanInsert($str, $options) : $str;
    }

    /**
     * Cleans up a Text::insert() formatted string with given $options depending on the 'clean' key in
     * $options. The default method used is text but html is also available. The goal of this function
     * is to replace all whitespace and unneeded markup around placeholders that did not get replaced
     * by Text::insert().
     *
     * @param string $str String to clean.
     * @param array $options Options list.
     * @return string
     * @see \Cake\Utility\Text::insert()
     */
    public static function cleanInsert(string $str, array $options): string
    {
        $clean = $options['clean'];
        if (!$clean) {
            return $str;
        }
        if ($clean === true) {
            $clean = ['method' => 'text'];
        }
        if (!is_array($clean)) {
            $clean = ['method' => $options['clean']];
        }
        switch ($clean['method']) {
            case 'html':
                $clean  += [
                    'word'        => '[\w,.]+',
                    'andText'     => true,
                    'replacement' => '',
                ];
                $kleenex = sprintf(
                    '/[\s]*[a-z]+=(")(%s%s%s[\s]*)+\\1/i',
                    preg_quote($options['before'], '/'),
                    $clean['word'],
                    preg_quote($options['after'], '/')
                );
                $str     = preg_replace($kleenex, $clean['replacement'], $str);
                if ($clean['andText']) {
                    $options['clean'] = ['method' => 'text'];
                    $str              = static::cleanInsert($str, $options);
                }
                break;
            case 'text':
                $clean += [
                    'word'        => '[\w,.]+',
                    'gap'         => '[\s]*(?:(?:and|or)[\s]*)?',
                    'replacement' => '',
                ];

                $kleenex = sprintf(
                    '/(%s%s%s%s|%s%s%s%s)/',
                    preg_quote($options['before'], '/'),
                    $clean['word'],
                    preg_quote($options['after'], '/'),
                    $clean['gap'],
                    $clean['gap'],
                    preg_quote($options['before'], '/'),
                    $clean['word'],
                    preg_quote($options['after'], '/')
                );
                $str     = preg_replace($kleenex, $clean['replacement'], $str);
                break;
        }

        return $str;
    }


    /**
     * Generate a random UUID version 4.
     *
     * Warning: This method should not be used as a random seed for any cryptographic operations.
     * Instead you should use the openssl or mcrypt extensions.
     *
     * It should also not be used to create identifiers that have security implications, such as
     * 'unguessable' URL identifiers. Instead you should use `Security::randomBytes()` for that.
     *
     * @see https://www.ietf.org/rfc/rfc4122.txt
     * @return string RFC 4122 UUID
     * @copyright Matt Farina MIT License https://github.com/lootils/uuid/blob/master/LICENSE
     * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
     *
     * @since 1.0.0 Copied from https://github.com/cakephp/utility
     */
    public static function uuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            random_int(0, 65535),
            random_int(0, 65535),
            // 16 bits for "time_mid"
            random_int(0, 65535),
            // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
            random_int(0, 4095) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            random_int(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            random_int(0, 65535),
            random_int(0, 65535),
            random_int(0, 65535)
        );
    }


    /**
     * Tokenizes a string using $separator, ignoring any instance of $separator that appears between
     * $leftBound and $rightBound.
     *
     * @param string $data The data to tokenize.
     * @param string $separator The token to split the data on.
     * @param string $leftBound The left boundary to ignore separators in.
     * @param string $rightBound The right boundary to ignore separators in.
     * @return string[] Array of tokens in $data.
     *
     * @since 1.0.0 Copied from https://github.com/cakephp/utility
     */
    public static function tokenize(
        string $data,
        string $separator = ',',
        string $leftBound = '(',
        string $rightBound = ')'
    ): array {
        if (empty($data)) {
            return [];
        }

        $depth   = 0;
        $offset  = 0;
        $buffer  = '';
        $results = [];
        $length  = mb_strlen($data);
        $open    = false;

        while ($offset <= $length) {
            $tmpOffset = -1;
            $offsets   = [
                mb_strpos($data, $separator, $offset),
                mb_strpos($data, $leftBound, $offset),
                mb_strpos($data, $rightBound, $offset),
            ];
            for ($i = 0; $i < 3; $i++) {
                if ($offsets[$i] !== false && ($offsets[$i] < $tmpOffset || $tmpOffset === -1)) {
                    $tmpOffset = $offsets[$i];
                }
            }
            if ($tmpOffset !== -1) {
                $buffer .= mb_substr($data, $offset, $tmpOffset - $offset);
                $char    = mb_substr($data, $tmpOffset, 1);
                if (!$depth && $char === $separator) {
                    $results[] = $buffer;
                    $buffer    = '';
                } else {
                    $buffer .= $char;
                }
                if ($leftBound !== $rightBound) {
                    if ($char === $leftBound) {
                        $depth++;
                    }
                    if ($char === $rightBound) {
                        $depth--;
                    }
                } else {
                    if ($char === $leftBound) {
                        if (!$open) {
                            $depth++;
                            $open = true;
                        } else {
                            $depth--;
                            $open = false;
                        }
                    }
                }
                $tmpOffset += 1;
                $offset     = $tmpOffset;
            } else {
                $results[] = $buffer . mb_substr($data, $offset);
                $offset    = $length + 1;
            }
        }
        if (empty($results) && !empty($buffer)) {
            $results[] = $buffer;
        }

        if (!empty($results)) {
            return array_map('trim', $results);
        }

        return [];
    }

    // ========================================================================


    // ========================================================================
    // Cake\Utility\Inflector
    // ------------------------------------------------------------------------

    /**
     * Returns the input lower_case_delimited_string as a CamelCasedString.
     *
     * @param string $string String to camelize
     * @param string $delimiter the delimiter in the input string
     * @return string CamelizedStringLikeThis.
     * @link https://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-camelcase-and-under-scored-forms
     */
    public static function camelize(string $string, string $delimiter = '_'): string
    {
        $result = str_replace(' ', '', static::humanize($string, $delimiter));
        return $result;
    }


    /**
     * Expects a CamelCasedInputString, and produces a lower_case_delimited_string
     *
     * @param string $string String to delimit
     * @param string $delimiter the character to use as a delimiter
     * @return string delimited string
     */
    public static function delimit(string $string, string $delimiter = '_'): string
    {
        $result = mb_strtolower(preg_replace('/(?<=\\w)([A-Z])/', $delimiter . '\\1', $string));
        return $result;
    }


    /**
     * Returns the input lower_case_delimited_string as 'A Human Readable String'.
     * (Underscores are replaced by spaces and capitalized following words.)
     *
     * @param string $string String to be humanized
     * @param string $delimiter the character to replace with a space
     * @return string Human-readable string
     * @link https://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-human-readable-forms
     */
    public static function humanize(string $string, string $delimiter = '_'): string
    {
        $result = explode(' ', str_replace($delimiter, ' ', $string));
        foreach ($result as &$word) {
            $word = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
        }
        $result = implode(' ', $result);
        return $result;
    }


    /**
     * Returns the input CamelCasedString as an underscored_string.
     *
     * Also replaces dashes with underscores
     *
     * @param string $string CamelCasedString to be "underscorized"
     * @return string underscore_version of the input string
     * @link https://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-camelcase-and-under-scored-forms
     */
    public static function underscore(string $string): string
    {
        return static::delimit(str_replace('-', '_', $string), '_');
    }

    /**
     * Returns camelBacked version of an underscored string.
     *
     * @param string $string String to convert.
     * @return string in variable form
     * @link https://book.cakephp.org/3.0/en/core-libraries/inflector.html#creating-variable-names
     */
    public static function variable(string $string): string
    {
        $camelized = static::camelize(static::underscore($string));
        $replace   = strtolower(substr($camelized, 0, 1));
        $result    = $replace . substr($camelized, 1);
        return $result;
    }
}
