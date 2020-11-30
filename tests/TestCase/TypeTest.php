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

declare(strict_types=1);

namespace NelsonMartell\Test\TestCase;

use stdClass;
use NelsonMartell\Test\DataProviders\TypeTestProvider;
use NelsonMartell\Type;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Exporter\Exporter;

use function NelsonMartell\typeof;

/**
 * @coversDefaultClass NelsonMartell\Type
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class TypeTest extends TestCase
{
    use TypeTestProvider;

    /**
     *
     * @var Exporter
     */
    public $exporter = null;

    public function setUp(): void
    {
        $this->exporter = new Exporter();
    }

    public function getTargetClassName()
    {
        return Type::class;
    }

    /**
     * @covers ::hasMethod
     *
     * @dataProvider hasMethodProvider
     *
     * @param mixed  $obj
     * @param string $name Method name.
     */
    public function testCanCheckIfAClassHasAMethod($obj, string $name): void
    {
        $type = new Type($obj);

        $this->assertTrue($type->hasMethod($name));
    }

    /**
     * @covers ::hasMethod
     *
     * @dataProvider hasNotMethodProvider
     *
     * @param mixed  $obj
     * @param string $name Method name.
     */
    public function testCanCheckIfAClassHasNotAMethod($obj, string $name): void
    {
        $type = new Type($obj);

        $this->assertFalse($type->hasMethod($name));
    }


    /**
     * @covers ::isNull
     * @covers ::isNotNull
     * @dataProvider goodConstructorArgumentsProvider
     *
     * @param mixed $obj
     */
    public function testCanCheckIfTypeIsNull($obj): void
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
     *
     * @param mixed $obj
     */
    public function testCanCheckIfTypeIsCustom($obj): void
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
    public function testCanCheckIfTypeCanBeConvertedToString(...$args): void
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
    public function testCanCheckIfTypeCanNotBeConvertedToString(...$args): void
    {
        $type = new Type(...$args);

        $actual = $type->canBeString();

        $this->assertFalse($actual);
    }

    /**
     * @dataProvider goodConstructorArgumentsProvider
     *
     * @param mixed $obj
     *
     * @since 1.0.0
     */
    public function testTypesEquality($obj): void
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
    public function testTypesInequality(): void
    {
        $t1 = new Type(new stdClass());
        $t2 = new Type(new stdClass());

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
    public function testIsMethod(bool $expected, $type, array $args): void
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
    public function testIsInMethod(bool $expected, $type, array $args): void
    {
        $this->assertEquals($expected, typeof($type)->isIn(...$args));
        $this->assertNotEquals(!$expected, typeof($type)->isIn(...$args));
    }

    /**
     * @dataProvider getInterfacesProvider
     *
     * @param mixed $obj
     * @param array $interfaces
     */
    public function testGetInterfaces($obj, array $interfaces): void
    {
        $type = new Type($obj);

        $reflections = $type->getInterfaces(true);
        $strings     = $type->getInterfaces();

        $this->assertIsArray($reflections);
        $this->assertIsArray($strings);

        $this->assertCount(count($interfaces), $reflections);
        $this->assertCount(count($interfaces), $strings);

        if (count($interfaces) > 0) {
            sort($interfaces);
            sort($strings);
            ksort($reflections);

            $this->assertEquals($interfaces, $strings);
            $this->assertEquals($strings, array_keys($reflections));
        }
    }

    /**
     * @dataProvider getTraitsProvider
     *
     * @param mixed $obj
     * @param array $traits
     */
    public function testGetExplicitTraitsInClass($obj, array $traits): void
    {
        if ($obj instanceof Type) {
            $type = $obj;
        } else {
            $type = new Type($obj);
        }

        $reflections = $type->getTraits(true);
        $strings     = $type->getTraits();

        $this->assertIsArray($reflections);
        $this->assertIsArray($strings);

        $this->assertEquals(count($strings), count($reflections), 'Not same count for strings and reflections');
        $this->assertCount(count($traits), $reflections);
        $this->assertCount(count($traits), $strings);

        if (count($traits) > 0) {
            sort($traits);
            sort($strings);
            ksort($reflections);

            $this->assertEquals($traits, $strings);
            $this->assertEquals($strings, array_keys($reflections));
        }
    }

    /**
     * @dataProvider getRecursiveTraitsProvider
     *
     * @param Type|mixed $obj
     * @param array $traits
     */
    public function testGetAllRecursiveTraitsInClass($obj, array $traits): void
    {
        if ($obj instanceof Type) {
            $type = $obj;
        } else {
            $type = new Type($obj);
        }

        $reflections = $type->getTraits(true, true);
        $strings     = $type->getTraits(false, true);

        $this->assertIsArray($reflections);
        $this->assertIsArray($strings);

        $this->assertEquals(count($strings), count($reflections), 'Not same count for strings and reflections');
        $this->assertCount(count($traits), $reflections);
        $this->assertCount(count($traits), $strings);

        if (count($traits) > 0) {
            sort($traits);
            sort($strings);
            ksort($reflections);

            $this->assertEquals($traits, $strings);
            $this->assertEquals($strings, array_keys($reflections));
        }
    }

    /**
     * @dataProvider hasPropertyProvider
     *
     * @param mixed $obj
     * @param string $name
     */
    public function testCanCheckIfTypeHasProperty($obj, string $name): void
    {
        /**
         * @var Type
         */
        $type = $obj;

        if (!($obj instanceof Type)) {
            $type = new Type($obj);
        }

        $actual = $type->hasProperty($name);

        $this->assertIsBool($actual, 'This method must return a boolean');

        $this->assertTrue($actual);
    }

    /**
     * @dataProvider hasNotPropertyProvider
     *
     * @param mixed $obj
     * @param string $name
     */
    public function testCanCheckIfTypeHasNotProperty($obj, string $name): void
    {
        /**
         * @var Type
         */
        $type = $obj;

        if (!($obj instanceof Type)) {
            $type = new Type($obj);
        }

        $actual = $type->hasProperty($name);

        $this->assertIsBool($actual, 'This method must return a boolean');

        $this->assertFalse($actual);
    }
}
