<?php

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
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\TestCase;

use InvalidArgumentException;
use NelsonMartell\Extensions\Text;
use NelsonMartell\Version;
use NelsonMartell\Test\DataProviders\VersionTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass NelsonMartell\Version
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * @since 0.6.0
 * */
class VersionTest extends TestCase
{
    use VersionTestProvider;

    public function getTargetClassName()
    {
        return Version::class;
    }

    /**
     * @depends NelsonMartell\Test\TestCase\VersionComponentTest::testParseMethod
     * @dataProvider parseableStringsProvider
     * @dataProvider parseableArraysProvider
     * @covers ::parse
     *
     * @param string|array $value
     */
    public function testPerformsConversionFromParseableStringAndArrays($value): void
    {
        $version = Version::parse($value);

        $this->addToAssertionCount(1);
    }

    /**
     * @depends testPerformsConversionFromParseableStringAndArrays
     * @dataProvider nonParseableValuesProvider
     * @covers ::parse
     *
     * @param mixed $value
     */
    public function testThrowsExceptionOnParsinInvalidValue($value): void
    {
        $this->expectException(InvalidArgumentException::class);

        $version = Version::parse($value);
    }


    /**
     * @testdox Can check if Version instance is valid
     * @depends testPerformsConversionFromParseableStringAndArrays
     * @dataProvider isValidProvider
     * @covers ::isValid
     *
     * @param  bool    $expected
     * @param  Version $version
     */
    public function testIsValid(bool $expected, Version $version): void
    {
        $actual = $version->isValid();

        $message = Text::format(
            '$version->{method}(); // {actual}',
            [
                'method' => 'isValid',
                'obj'    => static::export($version),
                'actual' => static::export($actual),
            ]
        );

        $this->assertIsBool($actual, $message . ' # Should return a boolean #');

        if ($expected === true) {
            $this->assertTrue($actual, $message);
        } else {
            $this->assertFalse($actual, $message);
        }
    }
}
