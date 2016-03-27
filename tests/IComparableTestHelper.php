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

namespace NelsonMartell\Test;

use NelsonMartell as NML;
use NelsonMartell\Extensions\String;
use NelsonMartell\IComparable;
use NelsonMartell\Object;
use NelsonMartell\Version;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \InvalidArgumentException;

/**
 * Test helper for classes implementing ``NelsonMartell\IComparable`` interface.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait IComparableTestHelper
{
    public abstract function getTargetClassInstance(); // use TestConstructorHelper;
    public abstract function getTargetClassName(); // use TestConstructorHelper;
    public abstract function export($obj); // use plugin/ExporterPlugin;

    /**
     *
     * @testdox Implements NelsonMartell\IComparable interface
     */
    public function testImplementsIComparableInterface()
    {
        $message = 'Do not implements '.IComparable::class.' interface.';
        $this->assertInstanceOf($this->getTargetClassName(), $this->getTargetClassInstance(), $message);
        $this->assertInstanceOf(IComparable::class, $this->getTargetClassInstance(), $message);
    }

    /**
     * @testdox Can compare relative position with other objects
     * @depends testImplementsIComparableInterface
     * @dataProvider IComparableCompareToMethodArgumentsProvider
     */
    public function testIComparableCompareToMethod($expected, IComparable $left, $right)
    {
        $actual = $left->compareTo($right);

        $message = String::format(
            '$obj->{method}({right}); // Returned: {actual}. $obj: {left})',
            [
                'class'  => $this->getTargetClassName(),
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
     * @testdox Can be compared with other objects
     * @depends testImplementsIComparableInterface
     * @dataProvider IComparableCompareMethodArgumentsProvider
     */
    public function testIComparableCompareMethod($expected, $left, $right)
    {
        $class = $this->getTargetClassName();
        $actual = $class::compare($left, $right);

        $message = String::format(
            '{class}::{method}({left}, {right}); // Returned: {actual}',
            [
                'class'  => $this->getTargetClassName(),
                'method' => 'compare',
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
     * @testdox Provides comparison function to array sorting.
     * @dataProvider IComparableCompareMethodArraysProvider
     */
    public function testUseIComparableCompareMethodInArraySorting(array $expected)
    {
        $actual = $expected;

        @shuffle($actual);

        $message = String::format(
            'usort({actual}, [{class}, {method}]);',
            [
                'class'  => $this->getTargetClassName(),
                'method' => 'compare',
                'actual' => static::export($actual)
            ]
        );

        @usort($actual, [$this->getTargetClassName(), 'compare']);

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * Datasets for ``testIComparableCompareToMethod(integer|null $expected, IComparable $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function IComparableCompareToMethodArgumentsProvider();

    /**
     * Datasets for ``testIComparableCompareMethod(integer|null $expected, mixed $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function IComparableCompareMethodArgumentsProvider();

    /**
     * Datasets for ``testIComparableCompareMethod(integer|null $expected, mixed $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function IComparableCompareMethodArraysProvider();
}
