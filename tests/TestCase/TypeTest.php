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

        $actual   = '<Type>'.$actual.'</Type>';
        $expected = '<Type>'.$expected.'</Type>';
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
     * @dataProvider canBeStringProvider
     *
     * @param array $args Arguments of constructor
     */
    public function testCanCheckIfTypeCanBeConvertedToString(...$args)
    {
        $type = new Type(...$args);

        $actual = $type->canBeString();

        $this->assertTrue($actual);
    }
    /**
     * @dataProvider canNotBeStringProvider
     *
     * @param array $args Arguments of constructor
     */
    public function testCanCheckIfTypeCanNotBeConvertedToString(...$args)
    {
        $type = new Type(...$args);

        $actual = $type->canBeString();

        $this->assertFalse($actual);
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


        $t1 = new Type('1');
        $t2 = new Type(1);

        $this->assertFalse($t1->equals($t2));
        $this->assertFalse($t2->equals($t1));

        $t1 = new Type(2.0);
        $t2 = new Type(2);

        $this->assertFalse($t1->equals($t2));
        $this->assertFalse($t2->equals($t1));
    }

    /**
     * Pruebas para Type::is()
     *
     * @dataProvider methodIsProvider
     *
     * @param  bool   $expected
     * @param  mixed   $type
     * @param  array  $args
     * @return void
     */
    public function testIsMethod(bool $expected, $type, array $args)
    {
        $this->assertEquals($expected, typeof($type)->is(...$args));
        $this->assertNotEquals(!$expected, typeof($type)->is(...$args));
    }

    /**
     * Pruebas para Type::isIn()
     *
     * @dataProvider methodIsInProvider
     *
     * @param  bool   $expected
     * @param  mixed   $type
     * @param  array  $args
     * @return void
     */
    public function testIsInMethod(bool $expected, $type, array $args)
    {
        $this->assertEquals($expected, typeof($type)->isIn(...$args));
        $this->assertNotEquals(!$expected, typeof($type)->isIn(...$args));
    }
}
