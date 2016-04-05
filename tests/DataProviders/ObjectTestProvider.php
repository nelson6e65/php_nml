<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition.
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

namespace NelsonMartell\Test\DataProviders;

use NelsonMartell as NML;
use NelsonMartell\Version;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\ConstructorMethodTester;
use NelsonMartell\Test\Helpers\IComparerTester;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait ObjectTestProvider
{
    use ExporterPlugin;
    use ConstructorMethodTester;
    use IComparerTester;

    # ConstructorMethodTester

    public function getTargetClassName()
    {
        return Object::class;
    }

    public function goodConstructorArgumentsProvider()
    {
        return [[]];
    }


    public function badConstructorArgumentsProvider()
    {
        return null;
    }
    #


    # IComparerTester
    public function compareMethodArgumentsProvider()
    {
        $v = new Version(1, 0, 9);
        $obj = new \stdClass();
        $obj->major = 1;
        $obj->minor = 0;
        $obj->build = 9;
        $obj->revision = null;

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
    #
}
