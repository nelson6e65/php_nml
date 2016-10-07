<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: NelsonMartell\Type
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
use NelsonMartell\Type;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\DataProviders\TypeTestProvider;
use \PHPUnit_Framework_TestCase as TestCase;
use SebastianBergmann\Exporter\Exporter;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class TypeTest extends TestCase
{
    use TypeTestProvider;

    public $exporter = null;

    public function setUp()
    {
        $this->exporter = new Exporter();
    }

    public function getTargetClassName()
    {
        return Type::class;
    }

    /**
     * Overrides default tests, due to this class constructor do not throws argument exceptions.
     * So, using any type should be pass.
     *
     * @testdox Do not throws error on creating new instances
     * @dataProvider badConstructorArgumentsProvider
     * @group Criticals
     */
    public function testConstructorWithBadArguments($obj)
    {
        $actual = null;
        $message = String::format(
            '$type = new {class}({obj});',
            [
                'class'   => Type::class,
                'obj'     => $this->exporter->shortenedExport($obj),
            ]
        );

        try {
            $actual = new Type($obj);
        } catch (\Exception $e) {
            $actual = $e;
            $message .= String::format(
                ' // # Constructor should not throws exceptions. Error: {0}',
                $this->exporter->export($e->getMessage())
            );
        }

        $this->assertInstanceOf(Type::class, $actual, $message);
    }

    /**
     * @coverage Type::toString
     * @coverage Type::__toString
     * @dataProvider toStringCheckProvider
     */
    public function testPerformsConversionToString($expected, $arg)
    {
        $obj    = new Type($arg);
        $actual = $obj->toString();

        $this->assertInternalType('string', $actual);
        $this->assertEquals($expected, $actual);

        $actual   = "<Type>$actual</Type>";
        $expected = "<Type>$expected</Type>";
        $this->assertEquals($expected, $actual);
    }


    /**
     * @coverage Type::hasMethod
     */
    public function testCanCheckIfAClassHasAMethod()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::hasMethod'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::isNUll
     * @coverage Type::isNotNUll
     * @dataProvider goodConstructorArgumentsProvider
     */
    public function testCanCheckIfTypeIsNull($obj)
    {
        if (is_null($obj)) {
            $actual = (new Type($obj))->isNull();
        } else {
            $actual = (new Type($obj))->isNotNull();
        }

        $this->assertTrue($actual);
    }

    /**
     * @dataProvider goodConstructorArgumentsProvider
     */
    public function testCanCheckIfTypeIsCustom($obj)
    {
        $actual = (new Type($obj))->isCustom();

        if (gettype($obj) == 'object') {
            $this->assertTrue($actual);
        } else {
            $this->assertFalse($actual);
        }
    }

    /**
     * @coverage Type::canBeString
     */
    public function testCanCheckIfTypeCanBeConvertedToString()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::canBeString'.'" has not been completed yet.'
        );
    }
}
