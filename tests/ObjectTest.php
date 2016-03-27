<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: [NelsonMartell] Object
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
use NelsonMartell\Extensions\String;
use NelsonMartell\Object;
use NelsonMartell\Version;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * @group Criticals
 * */
class ObjectTest extends TestCase
{
    use ExporterPlugin;

    /**
     * @coverage Object::compare
     * @dataProvider compareToProvider
     */
    public function testProvidesObjectsComparison($expected, $left, $right)
    {
        $actual = Object::compare($left, $right);

        $message = String::format(
            '{class}::{method}({left}, {right}); // Returned: {actual}',
            [
                'class'  => Object::class,
                'method' => 'compare',
                'left'   => static::export($left),
                'right'  => static::export($right),
                'actual' => static::export($actual)
            ]
        );

        if ($expected === 0) {
            $this->assertEquals(0, $actual, $message);
        } else {
            if ($expected === null) {
                $this->assertNull($actual, $message);
            } else {
                $major = $minor = 0;

                if ($expected < 0) {
                    $minor = $actual;
                } else {
                    $major = $actual;
                }

                $this->assertInternalType('integer', $actual, $message);
                $this->assertGreaterThan($minor, $major, $message);
                $this->assertLessThan($major, $minor, $message);
            }
        }
    }

    public function compareToProvider()
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


    /**
     * @dataProvider comparisonObjectsProvider
     */
    public function testProvidesSortingInArrays(array $expected)
    {
        $actual = $expected;

        @shuffle($actual);

        @usort($actual, array(Object::class, 'compare'));

        $this->assertEquals($expected, $actual, 'usort() failed.');
    }

    public function comparisonObjectsProvider()
    {
        return [
            'integer[]'           => [[-67, -9, 0, 4, 5, 6]],
            'string[]'            => [['a', 'b', 'c', 'd', 'z', 'z1']],
        ];
    }
}
