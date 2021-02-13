<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Extensions;

use InvalidArgumentException;
use NelsonMartell\IComparer;
use NelsonMartell\StrictObject;

use function NelsonMartell\msg;
use function NelsonMartell\typeof;

/**
 * Provides extension methods to handle class properties.
 *
 * @since 1.0.0
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
class PropertyExtension
{
    /**
     * Ensures that a string is a valid property name.
     *
     * @param string $name Property name to be ensured.
     *
     * @return string
     * @throws InvalidArgumentException if name do not follows the PHP variables naming convention.
     *
     * @see Text::ensureIsValidVarName()
     */
    public static function ensureIsValidName(string $name): string
    {
        try {
            return Text::ensureIsValidVarName($name);
        } catch (InvalidArgumentException $e) {
            $msg = msg('"{0}" is not a valid property name.', $name);
            throw new InvalidArgumentException($msg, 10, $e);
        }
    }

    /**
     * Ensures that the property is defined in the specified class.
     *
     * @param string $property
     * @param string $class
     * @param bool   $includeMagic
     *
     * @return string
     *
     * @throws InvalidArgumentException if `$property` is not valid, `$class` do not exists or `$class` has not the
     *   property.
     *
     * @see PropertyExtension::ensureIsValidName()
     */
    public static function ensureIsDefined(string $property, string $class, bool $includeMagic = false): string
    {
        $type = typeof($class, true);

        if (!$type->hasProperty(static::ensureIsValidName($property), true, $includeMagic)) {
            $msg = msg(
                '"{property}" property is not defined in "{class}" class or parent classes'
                . ($includeMagic ? ' (including magic properties).' : '.'),
                compact('property', 'class')
            );

            throw new InvalidArgumentException($msg, 11);
        }

        return $property;
    }
}
