<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
 *
 * Copyright © 2016-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use NelsonMartell\Extensions\Text;
use NelsonMartell\IComparer;

/**
 * Test helper for classes implementing ``NelsonMartell\IComparable`` interface.
 *
 * Note: Classes using this trait MUST use ConstructorMethodTester and ExporterPlugin traits too.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait IComparerTester
{
    public abstract function getTargetClassName(); // use ConstructorMethodTester;
    public abstract function getTargetClassReflection(); // use ConstructorMethodTester;
    public abstract function export($obj, $depth = 2, $short = false); // use plugin/ExporterPlugin;

    /**
     * Datasets for ``testCompareMethod(integer|null $expected, mixed $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function compareMethodArgumentsProvider();

    /**
     * Datasets for ``testCanUseCompareMethodInArraySorting(integer|null $expected, mixed $left, mixed $right)``.
     *
     * @return array
     */
    public abstract function compareMethodArraysProvider();


    /**
     * @testdox Can compare relative position of objects of different type
     * @dataProvider compareMethodArgumentsProvider
     */
    public function testCompareMethod($expected, $left, $right)
    {
        $class = $this->getTargetClassName();
        $actual = $class::compare($left, $right);

        $message = Text::format(
            '{class}::{method}({left}, {right}); // Returned: {actual}',
            [
                'class'  => $class,
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
     * @testdox Provides comparison function to array sorting
     * @dataProvider compareMethodArraysProvider
     */
    public function testCanUseCompareMethodInArraySorting(array $expected)
    {
        $actual = $expected;

        @shuffle($actual);

        $message = Text::format(
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
     * @testdox Is compliant with ``NelsonMartell\IComparer`` interface
     * @depends testCanUseCompareMethodInArraySorting
     */
    public function testIsCompliantWithIComparerIterface()
    {
        $message = Text::format(
            '"{0}" do not implements "{1}" interface.',
            $this->getTargetClassName(),
            IComparer::class
        );

        $this->assertContains(IComparer::class, $this->getTargetClassReflection()->getInterfaceNames(), $message);
    }
}
