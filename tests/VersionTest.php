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

namespace NelsonMartell\Test;

use NelsonMartell as NML;
use NelsonMartell\Version;
use NelsonMartell\VersionComponent;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class VersionTest extends TestCase
{
    use ExporterPlugin;

    /**
     * @coverage Version::__construct
     * @depends NelsonMartell\Test\VersionComponentTest::testConstructor
     * @dataProvider goodConstructorArgumentsProvider
     * @return Version
     */
    public function testCreatesNewInstances($major, $minor, $build = null, $rev = null)
    {
        $obj = new Version($major, $minor, $build, $rev);

        $this->assertInstanceOf(Version::class, $obj);
    }

    /**
     * @coverage Version::__construct
     * @expectedException InvalidArgumentException
     * @dataProvider badConstructorArgumentsProvider
     */
    public function testInformsWhenErrorOccursOnCreatingNewInstances($major, $minor, $build = null, $rev = null)
    {
        $obj = new Version($major, $minor, $build, $rev);
    }

    /**
     * Provides invalid arguments for constructor.
     *
     * @return array
     */
    public function badConstructorArgumentsProvider()
    {
        return [
            'Type: null (all)'               => [null, null],
            'Only first argument'            => [1, null],
            'Invalid $major and $minor type' => ['hello', 'world'],
            'Invalid $major type (string)'   => ['hello', 1],
            'Invalid $minor type (string)'   => [1, 'world'],
            '$major value < 0'               => [-1, 0],
            '$minor value < 0'               => [1, -3],
            '$build value < 0'               => [1, 0, -1, null],
            '$revision value < 0'            => [1, 0, 1, -1],
            '$revision while $build is not'  => [1, 0, null, -1],
        ];
    }

    /**
     * Provides valid arguments for constructor.
     *
     * @return array
     */
    public function goodConstructorArgumentsProvider()
    {
        return [
            'SemVer: Normal'                     => [1, 0, 0],
            'SemVer: Patch release '             => [1, 0, 1],
            'SemVer: Minor release'              => [1, 1, 0],
            'SemVer: Major release'              => [2, 0, 0],
            'SemVer: Pre-release alpha'          => [1, 0, '0-alpha'],
            'SemVer: Pre-release beta'           => [1, 0, '0-beta', 1],
            // 'SemVer: Pre-release build metadata' => [1, 0, '0-beta', '1+20130313144700'],
            'Windows version: Major'             => [1, 0, 0, 0],
            'Windows version: Minor'             => [1, 1, 0, 0],
            'Windows version: Build'             => [1, 2, 1, 0],
            'Windows version: Revision'          => [1, 3, 1, 2344234],
            'Git: describe'                      => [0, 5, '1-34-g6e5462c'],
            'Zero (minor)'                       => [0, 0], // is invalid, but can be created
            'Zero (build)'                       => [0, 0, 0], // is invalid, but can be created
            'Zero (revision)'                    => [0, 0, 0, 0], // is invalid, but can be created
        ];
    }

    /**
     * @coverage Version::parse
     * @depends NelsonMartell\Test\VersionComponentTest::testPerformsConversionFromString
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
     * @depends testCreatesNewInstances
     * @depends NelsonMartell\Test\VersionComponentTest::testPerformsConversionToString
     */
    public function testPerformsConversionToString()
    {
        $obj = new Version(0, 6, 0);
        $this->assertEquals('0.6.0', $obj->toString());

        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::toString|__toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::__toString
     * @coverage Version::toString
     * @depends testPerformsConversionToString
     * @depends NelsonMartell\Test\VersionComponentTest::testPerformsImplicitConversionToString
     */
    public function testPerformsImplicitConversionToString()
    {
        $obj = new Version(0, 6, 0);
        $this->assertEquals('v0.6.0', 'v'.$obj);

        $obj = new Version(0, 6, 0, 0);
        $this->assertEquals('v0.6.0.0', 'v'.$obj);

        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::__toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::isValid
     * @depends testCreatesNewInstances
     */
    public function testCanCheckIfVersionIsValid()
    {
        $obj = new Version(0, 0, 0, 0);
        $this->assertFalse($obj->isValid());

        $obj = new Version(0, 2, 0, 0);
        $this->assertTrue($obj->isValid());

        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::isValid'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::equals
     * @coverage Version::compareTo
     * @dataProvider compareToProvider
     * @d epends testCreatesNewInstances
     * @d epends testPerformsConversionFromString
     */
    public function testCanCompareWithOtherObjects($expected, Version $left, $right)
    {
        $actual = $left->compareTo($right);

        $message = String::format(
            '{left}->{method}({right}); // Returned: {actual}',
            [
                'class'  => Version::class,
                'method' => 'compareTo',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual)
            ]
        );

        if ($expected === 0) {
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

    public function compareToProvider()
    {
        $v = new Version(1, 0, 9);
        $obj = new \stdClass();
        $obj->major = 1;
        $obj->minor = 0;
        $obj->build = 9;
        $obj->revision = null;


        $args = [
            'Equals by reference'               => [0, $v, $v],
            'Equals by value'                   => [0, new Version(1, 0, 1), Version::parse('1.0.1')],
            'Major difference'                  => [-1, Version::parse('1.0.0'), Version::parse('2.0.0')],
            'Minor difference'                  => [1, Version::parse('1.1.0'), Version::parse('1.0.0')],
            'Build difference'                  => [1, Version::parse('1.0.1'), Version::parse('1.0.0')],
            'Revision difference'               => [-1, Version::parse('1.0.0.254'), Version::parse('1.0.0.389')],
            'Version < object'                  => [null, $v, $obj],
            'Version > array parseable'         => [1, Version::parse('1.1.0'), [0, 1, 999]],
            'Version < array parseable'         => [-1, Version::parse('1.1.0'), [2, 0]],
            'Version > array not parseable'     => [1, Version::parse('0.0.0'), ['invalid array']],
            'Version > string parseable'        => [1, Version::parse('1.1.0'), '0.1.999'],
            'Version < string parseable'        => [-1, Version::parse('1.1.0'), '2.0'],
            'Version > string not parseable'    => [1, Version::parse('1.1.0'), 'invalid string'],
            'Version = string not parseable'    => [0, Version::parse('0.0.0'), 'invalid string'],
            'Version = string not parseable'    => [1, Version::parse('0.0.0'), 'invalid string'],
        ];

        return $args;
    }

    /**
     * @coverage Version::equals
     * @coverage Version::compareTo
     * @coverage Object::compare
     * @depends testCanCompareWithOtherObjects
     * @depends NelsonMartell\Test\ObjectTest::testProvidesSortingInArrays
     * @dataProvider comparisonObjectsProvider
     */
    public function testCanBeSortedInArrays(array $expected)
    {
        $actual = $expected;

        @shuffle($actual);

        @usort($actual, array(Version::class, 'compare'));

        $message = String::format(
            'usort({actual}, array({class}, {method}));',
            [
                'class'  => static::export(Version::class),
                'method' => static::export('compare'),
                'actual' => static::export($actual)
            ]
        );

        $this->assertEquals($expected, $actual, $message);
    }

    public function comparisonObjectsProvider()
    {
        return [
            'Version[]' => [[
                new Version(1, 0, 1, 3),
                new Version(1, 0, 11, 3),
                new Version(1, 1, 1, 0),
                new Version(1, 3, 1, 9),
                Version::parse("2.3.2-3-g"),
                Version::parse("2.3.2-3-g726356"),
                Version::parse("2.3.2-4-g"),
                Version::parse("2.3.4-3-g"),
                Version::parse("2.3.4-3-gsh4hajk7"),
                Version::parse("2.3.4-3-gsh4hbjk7"),
                Version::parse("2.31.0-4-g"),
                Version::parse("2.31.1-4-g"),
                Version::parse("2.31.11-4-g"),
            ]],
            'Version[] + integer[]' => [[
                1,
                new Version(1, 0, 1, 3),
                new Version(1, 0, 11, 3),
                new Version(1, 1, 1, 0),
            ]],
            'Version[] + string[]'  => [[
                '0.0',
                new Version(0, 0, 9, 3),
                '0.1.0',
            ]],
            'Version[] + string[] (1 non parseable string)'  => [[
                '0.1.0',
                'invalid string',
                new Version(1, 0, 1, 3),
            ]],
            'Version[] + array[]'   => [[
                [],
                [0, 1, 0],
                new Version(1, 0, 1, 3),
            ]],
        ];
    }
}
