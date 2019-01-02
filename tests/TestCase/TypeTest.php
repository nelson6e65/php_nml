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
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\TestCase;

use stdClass;
use NelsonMartell\Extensions\Text;
use NelsonMartell\Test\DataProviders\TypeTestProvider;
use NelsonMartell\Type;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Exporter\Exporter;
use function NelsonMartell\typeof;

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
        $message = Text::format(
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
            $message .= Text::format(
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
     * @dataProvider goodConstructorArgumentsProvider
     */
    public function testCanCheckIfTypeCanBeConvertedToString($obj, $expected)
    {
        $type = new Type($obj);

        $actual = $type->canBeString();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider goodConstructorArgumentsProvider
     * @since 1.0.0
     */
    public function testTypesEquality($obj)
    {
        $t1 = new Type($obj);
        $t2 = new Type($obj);

        $this->assertTrue($t1->equals($t2));
        $this->assertTrue($t2->equals($t1));
        $this->assertFalse($t1->equals($obj));
    }

    /**
     *
     * @depends testTypesEquality
     * @since 1.0.0
     */
    public function testTypesInequality()
    {
        $t1 = new Type(new stdClass);
        $t2 = new Type(new stdClass);

        $this->assertTrue($t1->equals($t2));
        $this->assertTrue($t2->equals($t1));


        $t1 = new Type("1");
        $t2 = new Type(1);

        $this->assertFalse($t1->equals($t2));
        $this->assertFalse($t2->equals($t1));

        $t1 = new Type(2.0);
        $t2 = new Type(2);

        $this->assertFalse($t1->equals($t2));
        $this->assertFalse($t2->equals($t1));
    }
}
