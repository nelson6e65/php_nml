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
use NelsonMartell\VersionComponent;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class VersionComponentTest extends TestCase
{
    use ExporterPlugin;

    /**
     * @coverage VersionComponent::__construct
     * @param integer $int [description]
     * @param string $str [description]
     *
     * @return void
     * @dataProvider constructorArgumentsProvider
     */
    public function testCreatesNewInstances($int, $str)
    {
        $obj = new VersionComponent($int, $str);
        $this->assertInstanceOf(VersionComponent::class, $obj);
    }

    public function constructorArgumentsProvider()
    {
        return [
            'null values'       => [null, null],
            'Only integer part' => [1, null],
            'Only string part'  => [null, '-alpha'],
            'All arguments'     => [5, '-beta'],
            'Git describe'      => [19, '-g7575872'],
        ];
    }

    /**
     * @coverage VersionComponent::__construct
     * @expectedException InvalidArgumentException
     * @dataProvider badConstructorArgumentsProvider
     */
    public function testInformsWhenErrorOccursOnCreatingNewInstances($major, $minor, $build = null, $rev = null)
    {
        $obj = new VersionComponent($major, $minor, $build, $rev);
    }

    public function badConstructorArgumentsProvider()
    {
        return [
            'Negative integer part'        => [-1, null],
            'Invalid string value part'    => [0, 'erróneo'],
            'Invalid type (float) for string part'  => [0, 23.912],
            'Invalid type (object) for string part'  => [0, new \stdClass],
            'Invalid type (array) for string part'  => [0, ['no']],
        ];
    }

    /**
     * @coverage VersionComponent::parse
     */
    public function testPerformsConversionFromString()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::parse'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::__toString
     * @coverage VersionComponent::toString
     */
    public function testPerformsConversionToString()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::__toString|toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::__toString
     * @coverage VersionComponent::toString
     */
    public function testPerformsImplicitConversionToString()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::__toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::isNull
     * @coverage VersionComponent::isNotNull
     * @coverage VersionComponent::isDefault
     * @coverage VersionComponent::isNotDefault
     */
    public function testCanCheckIfVersionComponentIsInDefaultOrNullState()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::isNull|isNotNull|isDefault|isNotDefault'.
            '" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::equals
     * @coverage VersionComponent::compareTo
     * @dataProvider compareToProvider
     * @depends testCreatesNewInstances
     * @[depends] testPerformsConversionFromString
     */
    public function testCanCompareWithOtherObjects($expected, VersionComponent $left, $right)
    {
        $actual = $left->compareTo($right);

        $message = String::format(
            '{left}->{method}({right}); // Returned: {actual}',
            [
                'class'  => VersionComponent::class,
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
        $v = new VersionComponent(1, '-alpha');
        $obj = new \stdClass();
        $obj->intValue = 1;
        $obj->stringValue = '-alpha';


        $args = [
            'Equals by reference' => [0, $v, $v],
            'Equals by value'     => [
                0,
                new VersionComponent(1, '-alpha'),
                VersionComponent::parse('1-alpha')
            ],
            'VersionComponent: >' => [
                1,
                new VersionComponent(1, '-beta'),
                VersionComponent::parse('1-alpha')
            ],
            'VersionComponent: <' => [
                -1,
                new VersionComponent(1, '-alpha'),
                VersionComponent::parse('1-beta')
            ],
            'VersionComponent | stdClass: null' => [
                null,
                $v,
                $obj
            ],
        ];

        return $args;
    }

    /**
     * @coverage VersionComponent::equals
     * @coverage VersionComponent::compareTo
     * @coverage Object::compare
     * @depends testCanCompareWithOtherObjects
     * @depends NelsonMartell\Test\ObjectTest::testProvidesSortingInArrays
     * @dataProvider comparationObjectsProvider
     */
    public function testCanBeSortedInArrays(array $expected)
    {
        $actual = $expected;

        @shuffle($actual);

        @usort($actual, array(VersionComponent::class, 'compare'));

        $message = String::format(
            'usort({actual}, array({class}, {method}));',
            [
                'class'  => static::export(VersionComponent::class),
                'method' => static::export('compare'),
                'actual' => static::export($actual)
            ]
        );

        $this->assertEquals($expected, $actual, $message);
    }

    public function comparationObjectsProvider()
    {
        return [
            'VersionComponent[]' => [[
                VersionComponent::parse("0-4-g"),
                VersionComponent::parse("1-4-g"),
                VersionComponent::parse("2-3-g"),
                VersionComponent::parse("2-3-g726356"),
                VersionComponent::parse("2-4-g"),
                VersionComponent::parse("4-3-g"),
                VersionComponent::parse("4-3-gsh4hajk7"),
                VersionComponent::parse("4-3-gsh4hbjk7"),
                VersionComponent::parse("11-4-g"),
            ]],
            'VersionComponent[] + integer[]' => [[
                1,
                new VersionComponent(2, '-alpha'),
            ]],
            'VersionComponent[] + string[]'  => [[
                new VersionComponent(1, '-alpha'),
                '1-beta',
            ]],
            'VersionComponent[] + string[] (non parseable)'  => [[
                '----------',
                new VersionComponent(),
            ]],
            'VersionComponent[] + array[]'   => [[
                [],
                [0, 1, 0],
                new VersionComponent(1, '-alpha'),
            ]],
        ];
    }
}
