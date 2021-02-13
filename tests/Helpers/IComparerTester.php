<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\Helpers;

use ReflectionClass;
use NelsonMartell\Extensions\Text;
use NelsonMartell\IComparer;
use PHPUnit\Framework\TestCase;

/**
 * Test helper for classes implementing ``NelsonMartell\IComparable`` interface.
 *
 * Note: Classes using this trait MUST use ConstructorMethodTester and ExporterPlugin traits too.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.6.0
 * */
trait IComparerTester
{
    /**
     * @return string
     *
     * @see ConstructorMethodTester
     */
    abstract public function getTargetClassName(): string;

    /**
     * @param mixed $obj
     * @param int   $depth
     * @param bool  $short
     *
     * @return string
     *
     * @see ExporterPlugin
     */
    abstract public static function export($obj, int $depth = 2, bool $short = false): string;

    /**
     * Datasets for ``testCompareMethod(integer|null $expected, mixed $left, mixed $right)``.
     *
     * @return array
     */
    abstract public function compareMethodArgumentsProvider(): array;

    /**
     * Datasets for ``testCanUseCompareMethodInArraySorting(integer|null $expected, mixed $left, mixed $right)``.
     *
     * Must provide an array of sorted items.
     *
     * @return array
     */
    abstract public function compareMethodArraysProvider(): array;


    /**
     * @testdox Can compare relative position of objects of different type
     * @dataProvider compareMethodArgumentsProvider
     *
     * @param int|null $expected
     * @param mixed $left
     * @param mixed $right
     */
    public function testCompareMethod($expected, $left, $right): void
    {
        $class  = $this->getTargetClassName();
        $actual = $class::compare($left, $right);

        $message = Text::format(
            '{class}::{method}({left}, {right}); // Returned: {actual}',
            [
                'class'  => $class,
                'method' => 'compare',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual),
            ]
        );

        /** @var TestCase $this */
        if ($expected === 0) {
            $this->assertIsInt($actual, $message);
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

                $this->assertIsInt($actual, $message);
                $this->assertGreaterThan($minor, $major, $message);
                $this->assertLessThan($major, $minor, $message);
            }
        }
    }


    /**
     * @testdox Provides comparison function to array sorting
     * @dataProvider compareMethodArraysProvider
     *
     * @param array $expected
     */
    public function testCanUseCompareMethodInArraySorting(array $expected): void
    {
        $actual = $expected;

        @shuffle($actual);

        $message = Text::format(
            'usort({actual}, [{class}, {method}]);',
            [
                'class'  => $this->getTargetClassName(),
                'method' => 'compare',
                'actual' => static::export($actual),
            ]
        );

        @usort($actual, [$this->getTargetClassName(), 'compare']);

        /** @var TestCase $this */
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @testdox Is compliant with ``NelsonMartell\IComparer`` interface
     * @depends testCanUseCompareMethodInArraySorting
     */
    public function testIsCompliantWithIComparerIterface(): void
    {
        $className = $this->getTargetClassName();

        $message = Text::format(
            '"{0}" do not implements "{1}" interface.',
            $className,
            IComparer::class
        );

        $reflectionClass = new ReflectionClass($className);

        /** @var TestCase $this */
        $this->assertContains(IComparer::class, $reflectionClass->getInterfaceNames(), $message);
    }
}
