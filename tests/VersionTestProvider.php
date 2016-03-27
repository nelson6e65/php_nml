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

namespace NelsonMartell\Test;

use NelsonMartell as NML;
use NelsonMartell\Version;
use NelsonMartell\VersionComponent;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait VersionTestProvider
{

    /**
     * Provides invalid arguments for constructor.
     *
     * @return array
     */
    public function badConstructorArgumentsProvider()
    {
        return [
            'Type: null (all)'               => [null, null],
            'Only first argument'            => [1, null],
            'Invalid $major and $minor type' => ['hello', 'world'],
            'Invalid $major type (string)'   => ['hello', 1],
            'Invalid $minor type (string)'   => [1, 'world'],
            '$major value < 0'               => [-1, 0],
            '$minor value < 0'               => [1, -3],
            '$build value < 0'               => [1, 0, -1, null],
            '$revision value < 0'            => [1, 0, 1, -1],
            '$revision while $build is not'  => [1, 0, null, -1],
        ];
    }

    /**
     * Provides valid arguments for constructor.
     *
     * @return array
     */
    public function goodConstructorArgumentsProvider()
    {
        return [
            'SemVer: Normal'                     => [1, 0, 0],
            'SemVer: Patch release '             => [1, 0, 1],
            'SemVer: Minor release'              => [1, 1, 0],
            'SemVer: Major release'              => [2, 0, 0],
            'SemVer: Pre-release alpha'          => [1, 0, '0-alpha'],
            'SemVer: Pre-release beta'           => [1, 0, '0-beta', 1],
            // 'SemVer: Pre-release build metadata' => [1, 0, '0-beta', '1+20130313144700'],
            'Windows version: Major'             => [1, 0, 0, 0],
            'Windows version: Minor'             => [1, 1, 0, 0],
            'Windows version: Build'             => [1, 2, 1, 0],
            'Windows version: Revision'          => [1, 3, 1, 2344234],
            'Git: describe'                      => [0, 5, '1-34-g6e5462c'],
            'Zero (minor)'                       => [0, 0], // is invalid, but can be created
            'Zero (build)'                       => [0, 0, 0], // is invalid, but can be created
            'Zero (revision)'                    => [0, 0, 0, 0], // is invalid, but can be created
        ];
    }

    public function IComparableCompareToMethodArgumentsProvider()
    {
        $v = new Version(1, 0, 9);
        $obj = new \stdClass();
        $obj->major = 1;
        $obj->minor = 0;
        $obj->build = 9;
        $obj->revision = null;


        $args = [
            'Equals by reference'               => [0, $v, $v],
            'Equals by value'                   => [0, new Version(1, 0, 1), Version::parse('1.0.1')],
            'Major difference'                  => [-1, Version::parse('1.0.0'), Version::parse('2.0.0')],
            'Minor difference'                  => [1, Version::parse('1.1.0'), Version::parse('1.0.0')],
            'Build difference'                  => [1, Version::parse('1.0.1'), Version::parse('1.0.0')],
            'Revision difference'               => [-1, Version::parse('1.0.0.254'), Version::parse('1.0.0.389')],
            'Version < object'                  => [null, $v, $obj],
            'Version > array parseable'         => [1, Version::parse('1.1.0'), [0, 1, 999]],
            'Version < array parseable'         => [-1, Version::parse('1.1.0'), [2, 0]],
            'Version > array not parseable'     => [1, Version::parse('0.0.0'), ['invalid array']],
            'Version > string parseable'        => [1, Version::parse('1.1.0'), '0.1.999'],
            'Version < string parseable'        => [-1, Version::parse('1.1.0'), '2.0'],
            'Version > string not parseable'    => [1, Version::parse('1.1.0'), 'invalid string'],
            'integer|Version'                   => [1, $v, 9976645645656],
        ];

        return $args;
    }



    public function IComparableCompareMethodArgumentsProvider()
    {
        $v = new Version(1, 0, 9);
        $obj = new \stdClass();
        $obj->major = 1;
        $obj->minor = 0;
        $obj->build = 9;
        $obj->revision = null;

        $args = [
            'stdClass|Version' => [null, $obj, $v],
            'string|Version'   => [-1, '1.0.0.254', $v],
            'integer|Version'  => [-1, 9976645645656, $v],
            'float|Version'    => [-1, 1.342333, $v],
            'array|Version'    => [-1, [0, 1, 999], Version::parse('1.1.0')],
        ];

        return $args;
    }

    public function IComparableCompareMethodArraysProvider()
    {
        return [
            'Version[]' => [[
                new Version(1, 0, 1, 3),
                new Version(1, 0, 11, 3),
                new Version(1, 1, 1, 0),
                new Version(1, 3, 1, 9),
                Version::parse("2.3.2-3-g"),
                Version::parse("2.3.2-3-g726356"),
                Version::parse("2.3.2-4-g"),
                Version::parse("2.3.4-3-g"),
                Version::parse("2.3.4-3-gsh4hajk7"),
                Version::parse("2.3.4-3-gsh4hbjk7"),
                Version::parse("2.31.0-4-g"),
                Version::parse("2.31.1-4-g"),
                Version::parse("2.31.11-4-g"),
            ]],
            'Version[] + integer[]' => [[
                1,
                new Version(1, 0, 1, 3),
                new Version(1, 0, 11, 3),
                new Version(1, 1, 1, 0),
            ]],
            'Version[] + string[]'  => [[
                '0.0',
                new Version(0, 0, 9, 3),
                '0.1.0',
            ]],
            'Version[] + string[] (1 non parseable string)'  => [[
                '0.1.0',
                'invalid string',
                new Version(1, 0, 1, 3),
            ]],
            'Version[] + array[]'   => [[
                [],
                [0, 1, 0],
                new Version(1, 0, 1, 3),
            ]],
        ];
    }

    public function IEquatableMethodArgumentsProvider()
    {
        return [
            [true, new Version(1, 2), new Version(1, 2)],
            [false, new Version(1, 4), new Version(1, 2)],
            [false, new Version(1, 2, 1), new Version(1, 2, 2)],
            [false, new Version(1, 2, 1), 123],
            [false, new Version(1, 2, 1), 2345654675675675673453],
            [false, new Version(1, 2, 1), '1.2.1'],
            [false, new Version(1, 2, 1), [1, 2, 1]],
            [false, new Version(1, 2, 1), new \stdClass],
        ];
    }

    protected $parseableStrings = [
        'valid' => [
            '1.0',
            '0.2',
            '2.3.2-3-g726351',
            '2.3.2.3-2-g726352',
            '3.0.1',
            '4.0.2.0',
            '5.0.0.3-beta',
            '6.0.0-alpha',
        ],
        'invalid' => [
            '0.0',
            '1.0..1',
            '2.0.0-alpha.0',
            '2.3.2-3-g726353.3',
            '2.3.2-3-g726356.1-2-gyt4f4',
            '3.0.1-alpha.1',
            '4.0.0-alpha.0-beta',
            '5.0.1-alpha.2-beta',
        ],
    ];

    public function isValidProvider()
    {
        $args = [];

        foreach ($this->parseableStrings['valid'] as $str) {
            $args[$str] = [true, Version::parse($str)];
        }

        foreach ($this->parseableStrings['invalid'] as $str) {
            $args[$str] = [false, Version::parse($str)];
        }

        return $args;
    }
}
