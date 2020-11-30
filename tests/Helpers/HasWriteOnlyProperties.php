<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2017-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2017-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\Helpers;

use BadMethodCallException;
use NelsonMartell\IStrictPropertiesContainer;
use PHPUnit\Framework\TestCase;

/**
 * Split of ImplementsIStrictPropertiesContainer, for classes implementing any write-only property.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.7.0
 * */
trait HasWriteOnlyProperties
{
    /**
     */
    abstract public function testImplementsIStrictPropertiesContainerInterface(): void;

    abstract public function writeonlyPropertiesProvider();

    /**
     * @dataProvider writeonlyPropertiesProvider
     *
     * @param IStrictPropertiesContainer $obj
     * @param string                     $property
     * @param mixed                      $value
     */
    public function testWriteonlyPropertiesAreWritablesAreNotReadables(
        IStrictPropertiesContainer $obj,
        string $property,
        $value
    ): void {
        /** @var TestCase $this */
        $obj->$property = $value;
        $this->addToAssertionCount(1);

        $this->expectException(BadMethodCallException::class);
        $actual = $obj->$property;
    }
}
