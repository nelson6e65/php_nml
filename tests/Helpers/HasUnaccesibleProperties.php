<?php declare(strict_types=1);
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use BadMethodCallException;

use NelsonMartell\IStrictPropertiesContainer;

/**
 * Split of ImplementsIStrictPropertiesContainer, for classes implementing any read-only property
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.7.0
 * */
trait HasUnaccesibleProperties
{
    /**
     */
    abstract public function testImplementsIStrictPropertiesContainerInterface() : void;

    abstract public function unaccesiblePropertiesProvider() : array;

    /**
     * @dataProvider unaccesiblePropertiesProvider
     *
     * @param IStrictPropertiesContainer $obj
     * @param string                     $property
     * @param mixed                     $value
     */
    public function testUnaccessiblePropertiesThrowsCatchableError(
        IStrictPropertiesContainer $obj,
        string $property,
        $value = null
    ) : void {
        /** @var TestCase $this */
        $this->expectException(BadMethodCallException::class);

        if ($value === null) {
            // Getter exception
            $actual = $obj->$property;
        } else {
            // Setter exception
            $obj->$property = $value;
        }
    }
}
