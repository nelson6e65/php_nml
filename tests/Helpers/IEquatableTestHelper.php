<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
 *
 * Copyright © 2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use NelsonMartell as NML;
use NelsonMartell\Extensions\String;
use NelsonMartell\IEquatable;
use NelsonMartell\Object;
use \InvalidArgumentException;

/**
 * Test helper for classes implementing ``NelsonMartell\IEquatable`` interface.
 *
 * Note: Classes using this trait MUST use TestConstructorHelper and ExporterPlugin traits too.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait IEquatableTestHelper
{
    public abstract function getTargetClassName(); // use TestConstructorHelper;
    public abstract function getTargetClassReflection(); // use TestConstructorHelper;
    public abstract function export($obj); // use plugin/ExporterPlugin;

    /**
     * Datasets for ``testIEquatableEqualsMethod(bool $expected, IEquatable $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function IEquatableMethodArgumentsProvider();


    /**
     * @testdox Can check if instances are equals to other objects
     * @dataProvider IEquatableMethodArgumentsProvider
     */
    public function testIEquatableEqualsMethod($expected, IEquatable $left, $right)
    {
        $actual = $left->equals($right);

        $message = String::format(
            '$obj->{method}({right}); // Returned: {actual} ($obj: {left})',
            [
                'method' => 'equals',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual)
            ]
        );

        $this->assertInternalType('boolean', $actual, $message);

        if (!is_bool($expected)) {
            throw new InvalidArgumentException(String::format(
                '1st argument of data provider should be of "boolean" type, "{0}" given.',
                NML\typeof($expected)
            ));
        }

        $this->assertEquals($expected, $actual, $message);

        $this->assertTrue($left->equals($left), '[Shold be equal to itself]');
    }

    /**
     * @testdox Is compliant with ``NelsonMartell\IEquatable`` interface
     * @depends testIEquatableEqualsMethod
     */
    public function testIsCompliantWithIEquatableIterface()
    {
        $message = String::format(
            '"{0}" do not implements "{1}" interface.',
            $this->getTargetClassName(),
            IEquatable::class
        );

        $this->assertContains(IEquatable::class, $this->getTargetClassReflection()->getInterfaceNames(), $message);
    }
}
