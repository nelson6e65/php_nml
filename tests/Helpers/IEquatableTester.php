<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2020 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2020 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\Helpers;

use ReflectionClass;
use InvalidArgumentException;
use NelsonMartell\Extensions\Text;
use NelsonMartell\IEquatable;
use PHPUnit\Framework\TestCase;

use function NelsonMartell\typeof;

/**
 * Test helper for classes implementing ``NelsonMartell\IEquatable`` interface.
 *
 * Note: Classes using this trait MUST use ConstructorMethodTester and ExporterPlugin traits too.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait IEquatableTester
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
     * Datasets for ``testIEquatableEqualsMethod(bool $expected, IEquatable $left, mixed $right)``.
     *
     * @return array
     */
    abstract public function IEquatableMethodArgumentsProvider(): array;


    /**
     * @testdox Can check if instances are equals to other objects
     * @dataProvider IEquatableMethodArgumentsProvider
     *
     * @param int|null   $expected
     * @param IEquatable $left
     * @param mixed      $right
     */
    public function testIEquatableEqualsMethod($expected, IEquatable $left, $right): void
    {
        $actual = $left->equals($right);

        $message = Text::format(
            '$obj->{method}({right}); // Returned: {actual} ($obj: {left})',
            [
                'method' => 'equals',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual),
            ]
        );

        /** @var TestCase $this */
        $this->assertIsBool($actual, $message);

        if (!is_bool($expected)) {
            throw new InvalidArgumentException(Text::format(
                '1st argument of data provider should be of "boolean" type, "{0}" given.',
                typeof($expected)
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
        $className = $this->getTargetClassName();

        $message = Text::format(
            '"{0}" do not implements "{1}" interface.',
            $className,
            IEquatable::class
        );

        $reflectionClass = new ReflectionClass($className);

        /** @var TestCase $this */
        $this->assertContains(IEquatable::class, $reflectionClass->getInterfaceNames(), $message);
    }
}
