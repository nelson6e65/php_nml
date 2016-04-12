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

use NelsonMartell\Extensions\String;
use NelsonMartell\IComparable;

/**
 * Test helper for classes implementing ``NelsonMartell\IComparable`` interface.
 *
 * Note: Classes using this trait MUST use ConstructorMethodTester and ExporterPlugin traits too.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait IComparableTester
{
    public abstract function getTargetClassInstance(); // use ConstructorMethodTester;
    public abstract function getTargetClassName(); // use ConstructorMethodTester;
    public abstract function getTargetClassReflection(); // use ConstructorMethodTester;
    public abstract function export($obj, $depth = 2, $short = false); // use plugin/ExporterPlugin;

    /**
     * Datasets for ``testIComparableCompareToMethod(integer|null $expected, IComparable $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function IComparableCompareToMethodArgumentsProvider();

    /**
     * @testdox Can compare relative position with other objects
     * @dataProvider IComparableCompareToMethodArgumentsProvider
     */
    public function testIComparableCompareToMethod($expected, IComparable $left, $right)
    {
        $actual = $left->compareTo($right);

        $message = String::format(
            '$obj->{method}({right}); // Returned: {actual} ($obj: {left})',
            [
                'method' => 'compareTo',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual)
            ]
        );

        if ($expected === 0) {
            $this->assertInternalType('integer', $actual, $message);
            $this->assertEquals(0, $actual, $message);
        } else {
            if ($expected === null) {
                $this->assertNull($actual, $message);
            } else {
                $major = $minor = 0;

                if ($expected < 0) {
                    $minor = $actual;
                } else {
                    $major = $actual;
                }

                $this->assertInternalType('integer', $actual, $message);
                $this->assertGreaterThan($minor, $major, $message);
                $this->assertLessThan($major, $minor, $message);
            }
        }
    }

    /**
     * @testdox Is compliant with ``NelsonMartell\IComparable`` interface
     * @depends testIComparableCompareToMethod
     */
    public function testIsCompliantWithIComparableIterface()
    {
        $message = String::format(
            '"{0}" do not implements "{1}" interface.',
            $this->getTargetClassName(),
            IComparable::class
        );

        $this->assertContains(IComparable::class, $this->getTargetClassReflection()->getInterfaceNames(), $message);
    }
}
