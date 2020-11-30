<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2020 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2020 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\TestCase\Extensions;

use stdClass;
use ReflectionClass;
use InvalidArgumentException;
use NelsonMartell\Extensions\Text;
use NelsonMartell\Test\DataProviders\ExampleClass\ToString as ClassString;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\IComparerTester;
use PHPUnit\Framework\TestCase;

/**
 * Test case for `NelsonMartell\Extensions\Text` class.
 *
 * @see    Text
 * @author Nelson Martell <nelson6e65@gmail.com>
 *
 * @internal
 * */
class TextTest extends TestCase
{
    use IComparerTester;
    use ExporterPlugin;

    /**
     * @dataProvider validPositionalArgsListProvider
     * @dataProvider validNamedArgsListProvider
     */
    public function testPerformsFormatWithSecuentialAndNotSecuentialData($expected, $format, $data, $positional = false)
    {
        $actual = Text::format($format, $data);
        $this->assertEquals($expected, $actual);

        if ($positional) {
            $actual = Text::format($format, ...$data);
            $this->assertEquals($expected, $actual);
        }
    }


    /**
     * @dataProvider nonStringObjectsProvider
     */
    public function testDoNotPerformsFormatWithPlaceholdersValuesNotConvertiblesToString($obj)
    {
        $this->expectException(InvalidArgumentException::class);

        Text::format('{0}: {1}', InvalidArgumentException::class, $obj);
    }

    public function nonStringObjectsProvider()
    {
        return [
            'stdClass' => [new \stdClass()],
            'int[]'    => [[10, 20, 30, 40]],
            'string[]' => [['ten', '20', '30', '40']],
        ];
    }

    /**
     * expected, format, data, secuential
     **/
    public function validPositionalArgsListProvider()
    {
        $secuential = true;

        return [
            's: complete: basic array'                                    => [
                'Bob is 65 years old and has 101 cats.',
                '{0} is {1} years old and has {2} cats.',
                ['Bob', 65, 101],
                $secuential,
            ],
            's: complete: basic array with extra data not in placeholder' => [
                'Bob is 65 years old and has 101 cats.',
                '{0} is {1} years old and has {2} cats.',
                ['Bob', 65, 101, 'I am not here'],
                $secuential,
            ],
            's: missing value for placeholder'                            => [
                'Bob is 65 years old and has {2} cats.',
                '{0} is {1} years old and has {2} cats.',
                ['Bob', 65],
                $secuential,
            ],
            's: with some empty data'                                     => [
                'Bob is 65 years old and has  cats.',
                '{0} is {1} years old and has {2} cats.',
                ['Bob', 65, ''],
                $secuential,
            ],
            's: with some null data'                                      => [
                'Bob is 65 years old and has  cats.',
                '{0} is {1} years old and has {2} cats.',
                ['Bob', 65, null],
                $secuential,
            ],
            's: only 1 argument null'                                     => [
                'Null is .',
                'Null is {0}.',
                [null],
                $secuential,
            ],
            's: class implementing IConvertibleToString'                  => [
                'x = (-1, 1)',
                '{0} = ({1})',
                ['x', new ClassString()],
                $secuential,
            ],
        ];
    }

    /**
     * expected, format, data, secuential = false
     **/
    public function validNamedArgsListProvider()
    {
        return [
            'n: complete'                                => [
                'Bob is 65 years old and has 101 cats.',
                '{name} is {age} years old and has {n} cats.',
                [
                    'name' => 'Bob',
                    'age'  => 65,
                    'n'    => 101,
                ],
            ],
            'n: complete with numeric index'             => [
                'Bob is 65 years old and has 101 cats.',
                '{name} is {age} years old and has {7} cats.',
                [
                    'name' => 'Bob',
                    'age'  => 65,
                    7      => 101,
                ],
            ],
            'n: missing value for placeholder'           => [
                'Bob is 65 years old and has {n} cats.',
                '{name} is {age} years old and has {n} cats.',
                [
                    'name' => 'Bob',
                    'age'  => 65,
                ],
            ],
            'n: complete with some empty value'          => [
                'Bob is 65 years old and has  cats.',
                '{name} is {age} years old and has {n} cats.',
                [
                    'name' => 'Bob',
                    'age'  => 65,
                    'n'    => '',
                ],
            ],
            'n: complete with some null values'          => [
                'Bob is 65 years old and has  cats.',
                '{name} is {age} years old and has {n} cats.',
                [
                    'name' => 'Bob',
                    'age'  => 65,
                    'n'    => null,
                ],
            ],
            'n: class implementing IConvertibleToString' => [
                'x = (-1, 1)',
                '{var} = ({coords})',
                [
                    'var'    => 'x',
                    'coords' => new ClassString(),
                ],
            ],
        ];
    }

    // IComparerTester ==============================================================================

    public function getTargetClassName()
    {
        return Text::class;
    }

    public function getTargetClassReflection()
    {
        return new ReflectionClass($this->getTargetClassName());
    }



    public function compareMethodArgumentsProvider()
    {
        return [
            'stdClass > string'      => [1, new stdClass(), 'stdClass'],
            'string < stdClass'      => [-1, 'stdClass', new stdClass()],
            'string > null'          => [1, 's', null],
            'null < string'          => [-1, null, 's'],
            'string (empty) == null' => [0, '', null],
            'null == string (empty)' => [0, null, ''],
        ];
    }

    public function compareMethodArraysProvider()
    {
        return [
            [[-1, 0, 1, 'b', 'c', 'd', 'z', 'z1', new stdClass()]],
        ];
    }
}
