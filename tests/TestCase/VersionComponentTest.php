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
use NelsonMartell\VersionComponent;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\ConstructorMethodTester;
use NelsonMartell\Test\Helpers\IComparableTester;
use NelsonMartell\Test\Helpers\IComparerTester;
use NelsonMartell\Test\Helpers\IEquatableTester;
use NelsonMartell\Test\DataProviders\VersionComponentTestProvider;
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
    use ConstructorMethodTester;
    use IComparableTester;
    use IComparerTester;
    use IEquatableTester;

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
     * @dataProvider nullOrDefaultStatesProvider
     */
    public function testCanCheckIfVersionComponentIsInDefaultOrNullState($expected, VersionComponent $versionComponent)
    {
        static $format = '$versionComponent->{method}(); // {actual}';

        $actuals['isDefault']    = $versionComponent->isDefault();
        $actuals['isNotDefault'] = $versionComponent->isNotDefault();
        $actuals['isNull']       = $versionComponent->isNull();
        $actuals['isNotNull']    = $versionComponent->isNotNull();

        $messages = [];

        foreach ($actuals as $method => $actual) {
            $messages[$method] = String::format($format, ['method' => $method, 'actual' => static::export($actual)]);
        }

        foreach ($actuals as $method => $actual) {
            // Pre-tests for returning type
            $this->assertInternalType('boolean', $actual, $messages[$method].' # Should return a boolean #');
        }

        // Pre-tests for different values
        $this->assertNotEquals(
            $actuals['isDefault'],
            $actuals['isNotDefault'],
            $messages['isDefault'].PHP_EOL.$messages['isNotDefault']
        );

        $this->assertNotEquals(
            $actuals['isNull'],
            $actuals['isNotNull'],
            $messages['isNull'].PHP_EOL.$messages['isNotNull']
        );


        // Test expected
        if ($expected === 'default') {
            $this->assertTrue($actuals['isDefault'], $messages['isDefault']);

            // Can't be null AND default
            $this->assertNotEquals(
                $actuals['isNull'],
                $actuals['isDefault'],
                '#Can\'t be both, DEFAULT and NULL, at the same time'.PHP_EOL.
                $messages['isDefault'].PHP_EOL.
                $messages['isNull']
            );
        } elseif ($expected === 'null') {
            $this->assertTrue($actuals['isNull'], $messages['isNull']);

            // Can't be null AND default
            $this->assertNotEquals(
                $actuals['isNull'],
                $actuals['isDefault'],
                '#Can\'t be both, NULL and DEFAULT, at the same time'.PHP_EOL.
                $messages['isNull'].PHP_EOL.
                $messages['isDefault']
            );
        } else {
            $this->assertTrue($actuals['isNotDefault'], $messages['isNotDefault']);
            $this->assertTrue($actuals['isNotNull'], $messages['isNotNull']);
        }
    }
}
