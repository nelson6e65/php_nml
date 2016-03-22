<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: [NelsonMartell\Extensions] String
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
namespace NelsonMartell\Test\Extensions;

use NelsonMartell as NML;
use NelsonMartell\Extensions\String;
use NelsonMartell\Type;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 * Test case for `NelsonMartell\Extensions\String` class.
 *
 * @see    String
 * @author Nelson Martell <nelson6e65@gmail.com>
 *
 * @internal
 * */
class StringTest extends TestCase
{
    public function testPerformsFormatForStringWithIntegerPlaceholders()
    {
        $expected = 'Mi nombre es Juan';
        $actual = String::format('Mi nombre es {0}', ['Juan']);
        $this->assertEquals($expected, $actual);

        $actual = String::format("Mi nombre es {0}", 'Juan');
        $this->assertEquals($expected, $actual);

        $name = 'Juan';
        $actual = String::format("Mi nombre es {0}", $name);
        $this->assertEquals($expected, $actual);

        $expected = 'Me llamo Nelson y tengo 29 años de edad.';
        $name = 'Nelson';
        $age = 29;
        $actual = String::format('Me llamo {0} y tengo {1} años de edad.', $name, $age);
        $this->assertEquals($expected, $actual);

        $actual = String::format('Me llamo {0} y tengo {1} años de edad.', [$name, $age]);
        $this->assertEquals($expected, $actual);
    }

    public function testPerformsFormatForStringsWithStringPlaceholders()
    {
        $expected = 'Mi nombre es Juan';
        $actual = String::format('Mi nombre es {name}', ["name" => "Juan"]);
        $this->assertEquals($expected, $actual);

        $expected = 'Tengo 20 años de edad.';
        $actual = String::format('Tengo {age} años de edad.', ["name" => "Juan", 'age' => 20]);
        $this->assertEquals($expected, $actual);
    }

    public function testPerformsFormatWithManyData()
    {
        $expected = 'Mi nombre es Juan y tengo 61 años de edad.';
        $format   = 'Mi nombre es {name} y tengo {age} años de edad.';
        $actual   = String::format($format, ['age' => 61, 'name' => 'Juan']);
        $this->assertEquals($expected, $actual);

        $format = 'Mi nombre es {1} y tengo {0} años de edad.';
        $actual = String::format($format, [61, 'Juan']);
        $this->assertEquals($expected, $actual);

        $actual = String::format($format, 61, 'Juan');
        $this->assertEquals($expected, $actual);

        $expected = 'Números: 1, 2, 3, 4, 5, 6, 7, 8, 9 y 10.';
        $format   = 'Números: ';
        for ($i = 0; $i < 8; $i++) {
            $format .= "{{$i}}, ";
        }
        $format .= '{8} y {9}.';
        $actual   = String::format($format, range(1, 10));
        $this->assertEquals($expected, $actual);
    }

    /**
     * @depends testPerformsFormatWithManyData
     */
    public function testPerformsFormatIgnoringNotMatchingData()
    {
        $expected = 'Mi nombre es {name} y tengo {age} años de edad.';
        $actual = String::format('Mi nombre es {name} y tengo {age} años de edad.', ['fake_name' => 'Juan']);
        $this->assertEquals($expected, $actual);

        $actual = String::format('Mi nombre es {name} y tengo {age} años de edad.', null);
        $this->assertEquals($expected, $actual);

        $actual = String::format('Mi nombre es {name} y tengo {age} años de edad.', null, null, null);
        $this->assertEquals($expected, $actual);

        $expected = 'Mi nombre es Juan y tengo {age} años de edad.';
        $actual = String::format('Mi nombre es {name} y tengo {age} años de edad.', ['name' => 'Juan']);
        $this->assertEquals($expected, $actual);

        $expected = 'Mi nombre es {name} y tengo 54 años de edad.';
        $actual = String::format('Mi nombre es {name} y tengo {age} años de edad.', ['age' => 54]);
        $this->assertEquals($expected, $actual);
    }

    public function testPerformsFormatWithArgumentsOfDifferentTypesConvertiblesToString()
    {
        $expected = 'Invalid argument type. "major" (position 0) must to be an instance of "integer"; "string" given.';

        $major = 'Non Number';
        $args = [
            'name'     => 'major',
            'expected' => NML\typeof(0),
            'pos'      => 0,
            'actual' => NML\typeof($major),
        ];

        // Esto produce un error fatal debido a una debilidad en el uso de la función `asort` en el método
        //  ``Cake\Utility\Text::.insert()``, ya que debería comparar como cadena usando el flag `SORT_STRING`
        //  pero que se evita convirtiendo los valores a string en el método String::format().

        $actual = String::format('Invalid argument type.', null);
        $actual .= String::format(
            ' "{name}" (position {pos}) must to be an instance of "{expected}"; "{actual}" given.',
            $args
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider nonStringObjectsProvider
     */
    public function testDoNotPerformsFormatWithPlaceholdersValuesNotConvertiblesToString($obj)
    {
        $format = PHP_EOL.'This test should throws an "{0}" with data: {testErrorData}.'.PHP_EOL;

        $str = String::format($format, [InvalidArgumentException::class, 'testErrorData' => $obj]);
    }

    public function nonStringObjectsProvider()
    {
        return [
            'stdClass' => [new \stdClass],
            'int[]'    => [[10, 20, 30, 40]],
            'string[]' => [['ten', '20', '30', '40']],
        ];
    }
}
