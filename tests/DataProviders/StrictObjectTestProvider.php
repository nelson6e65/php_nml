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

namespace NelsonMartell\Test\DataProviders;

use stdClass;

use NelsonMartell\StrictObject;

use NelsonMartell\Test\DataProviders\ExampleClass\A;

use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\IComparerTester;
use NelsonMartell\Test\Helpers\ConstructorMethodTester;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.6.0
 * @internal
 * */
trait StrictObjectTestProvider
{
    use ExporterPlugin;
    use ConstructorMethodTester;
    use IComparerTester;

    // ConstructorMethodTester

    public function getTargetClassName()
    {
        return StrictObject::class;
    }

    public function goodConstructorArgumentsProvider()
    {
        return [[]];
    }


    public function badConstructorArgumentsProvider()
    {
        return null;
    }
    //


    // IComparerTester
    public function compareMethodArgumentsProvider()
    {
        $obj       = new \stdClass();
        $obj->one  = 1;
        $obj->nine = 9;

        $args = [
            'integers: same value, +-'      => [1, 5, -5],
            'integers: same value, -+'      => [-1, -5, 5],
            'integers: same value, --'      => [0, -5, -5],
            'integers: same value, ++'      => [0, 5, 5],
            'integers: different value, +-' => [1, 90, -8],
            'integers: different value, -+' => [-1, -8, 90],
            'integers: different value, --' => [1, -8, -90],
            'integers: different value, ++' => [-1, 8, 90],
            'strings: same'                 => [0, 'world', 'world'],
            'strings: leading space, <'     => [-1, 'world', 'world '],
            'strings: leading space, >'     => [1, 'world ', 'world'],
            'strings: different chars, >'   => [1, 'hola', 'hello'],
            'strings: different chars, <'   => [-1, 'hello', 'hola'],
            'arrays: same'                  => [0, ['one' => 'world'], ['one' => 'world']],
            'arrays: different count, >'    => [1, ['hola', 'mundo'], ['hello']],
            'arrays: different count, <'    => [-1, ['hello'], ['hola', 'mundo']],
            'array > array (values)'        => [1, ['hola', 'mundo'], ['hello', 'world']],
            'array < array (values)'        => [-1, ['hello', 'world'], ['hola', 'mundo']],
            'array < array (keys)'          => [-1, ['hola', 'mundo'], ['one' => 'hello', 'two' => 'world']],
            'array < stdClass'              => [-1, [], new stdClass],
            'stdClass > array'              => [1, new stdClass, []],
            'array > null'                  => [1, [], null],
            'null < array'                  => [-1, null, []],
            'array > int'                   => [1, [], 1],
            'int < array'                   => [-1, 1, []],
            'array > string'                => [1, [], '1'],
            'string < array'                => [-1, '1', []],
            'same reference =='             => [0, $obj, $obj],
            'empty classes =='              => [0, new A(), new A()],
            'different class'               => [null, new A(), new stdClass],
            'stdClass (empty) < stdClass'   => [-1, new \stdClass, $obj],
            'stdClass > stdClass (empty)'   => [1, $obj, new \stdClass],
            'stdClass > integer'            => [1, $obj, 1234],
            'integer < stdClass'            => [-1, 1234, $obj],
            'stdClass > string'             => [1, $obj, '1234'],
            'string < stdClass'             => [-1, '1234', $obj],
            'stdClass > null'               => [1, $obj, null],
            'null < stdClass'               => [-1, null, $obj],
            'float > null'                  => [1, 1.23, null],
            'null < float'                  => [-1, null, 1.23],
            'null < float (negative)'       => [-1, null, -1.23],
            'float (negative) > null'       => [1, -1.23, null],
            'float == integer'              => [0, 1.00, 1],
            'float != integer'              => [1, 1.0000001, 1],
            'floats near to zero'           => [1, 0.00000000001, -0.00000000001],
            'float > integer'               => [1, 1.23, 1],
            'integer < float'               => [-1, 1, 1.23],
            'floats <'                      => [-1, 1.234, 1.2345],
            'bool cant integer'             => [null, false, 19],
            'integer cant bool'             => [null, 1, true],
            'boolean < boolean'             => [-1, false, true],
            'boolean > boolean'             => [1, true, false],
        ];

        return $args;
    }

    public function compareMethodArraysProvider()
    {
        return [
            'integer[]'           => [[-67, -9, 0, 4, 5, 6]],
            'string[]'            => [['a', 'b', 'c', 'd', 'z', 'z1']],
        ];
    }
    //
}
