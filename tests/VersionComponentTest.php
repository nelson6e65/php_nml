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
    use IComparableTestHelper;

    public function getTargetClassName()
    {
        return VersionComponent::class;
    }

    /**
     * @testdox Performs conversion from compatible objects
     * @coverage VersionComponent::parse
     * @dataProvider goodVersionComponentParseMethodArgumentsProvider
     */
    public function testParseMethod(VersionComponent $expected, $obj)
    {
        $actual = VersionComponent::parse($obj);

        $message = String::format(
            '{class}::{method}({obj}); // {actual}',
            [
                'class'  => VersionComponent::class,
                'method' => 'isValid',
                'obj'    => static::export($obj),
                'actual' => static::export($actual)
            ]
        );

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @testdox Informs if error occurs on parsing incompatible objects
     * @coverage VersionComponent::parse
     * @dataProvider badVersionComponentParseMethodArgumentsProvider
     * @expectedException \InvalidArgumentException
     */
    public function testParseMethodWithInvalidArguments($obj)
    {
        $actual = VersionComponent::parse($obj);
    }

    /**
     * @coverage VersionComponent::__toString
     * @coverage VersionComponent::toString
     * @dataProvider versionComponentToStringMethodArgumentsProvider
     */
    public function testPerformsConversionToString($expected, VersionComponent $versionComponent)
    {
        $actual = $versionComponent->toString();

        $message = String::format(
            '$versionComponent->{method}(); // {actual}',
            [
                'method' => 'toString',
                'actual' => static::export($actual)
            ]
        );

        $this->assertInternalType('string', $actual, $message.' # Should return a string #');
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @coverage VersionComponent::__toString
     * @coverage VersionComponent::toString
     * @depends testPerformsConversionToString
     * @dataProvider versionComponentToStringMethodArgumentsProvider
     */
    public function testPerformsImplicitConversionToString($str, VersionComponent $obj)
    {
        $expected = "<VersionComponent>$str</VersionComponent>";
        $actual   = "<VersionComponent>$obj</VersionComponent>";

        $this->assertEquals($expected, $actual);
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
}
