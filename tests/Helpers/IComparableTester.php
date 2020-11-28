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
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use ReflectionClass;

use NelsonMartell\Extensions\Text;

use NelsonMartell\IComparable;

use PHPUnit\Framework\TestCase;

/**
 * Test helper for classes implementing ``NelsonMartell\IComparable`` interface.
 *
 * Note: Classes using this trait MUST use ConstructorMethodTester and ExporterPlugin traits too.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.6.0
 * */
trait IComparableTester
{
    /**
     * @return string
     *
     * @see ConstructorMethodTester
     */
    abstract public function getTargetClassName() : string;

    /**
     * @param mixed $obj
     * @param int   $depth
     * @param bool  $short
     *
     * @return string
     *
     * @see ExporterPlugin
     */
    abstract public function export($obj, int $depth = 2, bool $short = false) : string;

    /**
     * Datasets for ``testIComparableCompareToMethod(integer|null $expected, IComparable $left, mixed $right)``.
     *
     * @return array
     */
    abstract public function IComparableCompareToMethodArgumentsProvider();

    /**
     * @testdox Can compare relative position with other objects
     * @dataProvider IComparableCompareToMethodArgumentsProvider
     *
     * @param int|null    $expected
     * @param IComparable $left
     * @param mixed       $right
     *
     * @see IComparable::compareTo()
     */
    public function testIComparableCompareToMethod($expected, IComparable $left, $right) : void
    {
        /** @var TestCase $this */
        $actual = $left->compareTo($right);

        $message = Text::format(
            '$obj->{method}({right}); // Returned: {actual} ($obj: {left})',
            [
                'method' => 'compareTo',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual)
            ]
        );

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
     * @testdox Is compliant with ``NelsonMartell\IComparable`` interface
     * @depends testIComparableCompareToMethod
     */
    public function testIsCompliantWithIComparableIterface()
    {
        $message = Text::format(
            '"{0}" do not implements "{1}" interface.',
            $this->getTargetClassName(),
            IComparable::class
        );

        $classReflection = new ReflectionClass($this->getTargetClassName());

        /** @var TestCase $this */
        $this->assertContains(IComparable::class, $classReflection->getInterfaceNames(), $message);
    }
}
