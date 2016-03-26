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
    use VersionComponentTestProvider;
    use TestConstructorHelper;

    public function getTargetClassName()
    {
        return VersionComponent::class;
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
     * @[depends] testConstructor
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

    /**
     * @coverage VersionComponent::equals
     * @coverage VersionComponent::compareTo
     * @coverage Object::compare
     * @depends testCanCompareWithOtherObjects
     * @depends NelsonMartell\Test\ObjectTest::testProvidesSortingInArrays
     * @dataProvider compareProvider
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
}
