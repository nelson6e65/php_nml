<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use ReflectionClass;

use NelsonMartell\Extensions\Text;

use NelsonMartell\IConvertibleToString;

/**
 * Test helper for classes implementing {@see IConvertibleToString} interface.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 1.0.0
 * */
trait ImplementsIConvertibleToString
{
    /**
     * @return string
     */
    abstract public function getTargetClassName() : string;

    /**
     * @return array
     */
    abstract public function toStringProvider() : array;

    /**
     *
     */
    public function testImplementsIConvertibleToString() : void
    {
        $class = new ReflectionClass($this->getTargetClassName());

        $message = Text::format(
            '"{0}" do not implements "{1}" interface.',
            $this->getTargetClassName(),
            IConvertibleToString::class
        );

        $this->assertContains(
            IConvertibleToString::class,
            $class->getInterfaceNames(),
            $message
        );
    }

    /**
     * @covers ::toString
     * @covers ::__toString
     * @dataProvider toStringProvider
     *
     * @param string                $expected
     * @param IConvertibleToString  $obj
     *
     * @see IConvertibleToString::toString()
     * @see IConvertibleToString::__toString()
     */
    public function testPerformsConversionToString(string $expected, IConvertibleToString $obj): void
    {
        $this->assertSame($expected, $obj->toString(), 'Failed explicit conversion to string');

        $this->assertSame($expected, $obj.'', 'Failed implicit conversion to string');
    }
}
