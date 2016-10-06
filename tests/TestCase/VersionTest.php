<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: [NelsonMartell] Version
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

namespace NelsonMartell\Test\TestCase;

use NelsonMartell as NML;
use NelsonMartell\Version;
use NelsonMartell\VersionComponent;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\DataProviders\VersionTestProvider;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class VersionTest extends TestCase
{
    use VersionTestProvider;

    public function getTargetClassName()
    {
        return Version::class;
    }

    /**
     * @coverage Version::parse
     * @depends NelsonMartell\Test\TestCase\VersionComponentTest::testParseMethod
     */
    public function testPerformsConversionFromString()
    {
        // Test for array ['invalid', 'array']
        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::parse'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::parse
     * @depends NelsonMartell\Test\TestCase\VersionComponentTest::testPerformsConversionToString
     * @dataProvider toStringMethodProvider
     */
    public function testPerformsConversionToString($expected, Version $version)
    {
        $actual = $version->toString();

        $message = String::format(
            '$version->{method}(); // {actual}',
            [
                'method' => 'toString',
                'actual' => static::export($actual)
            ]
        );

        $this->assertInternalType('string', $actual, $message.' # Should return a string #');
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @coverage Version::__toString
     * @coverage Version::toString
     * @depends testPerformsConversionToString
     * @dataProvider toStringMethodProvider
     */
    public function testPerformsImplicitConversionToString($str, Version $obj)
    {
        $expected = "<Version>$str</Version>";
        $actual   = "<Version>$obj</Version>";

        $this->assertEquals($expected, $actual);
    }

    /**
     * @testdox Can check if Version instance is valid
     * @coverage Version::isValid
     * @dataProvider isValidProvider
     */
    public function testIsValid($expected, Version $version)
    {
        $actual = $version->isValid();

        $message = String::format(
            '$version->{method}(); // {actual}',
            [
                'method' => 'isValid',
                'obj'    => static::export($version),
                'actual' => static::export($actual)
            ]
        );

        $this->assertInternalType('boolean', $actual, $message.' # Should return a boolean #');

        if ($expected === true) {
            $this->assertTrue($actual, $message);
        } else {
            $this->assertFalse($actual, $message);
        }
    }
}
